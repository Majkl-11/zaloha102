<?php

class SmerovacKontroler extends Kontroler
{
    protected Kontroler $kontroler;

    private function pomlckyDoVelbloudiNotace(string $text): string
    {
        $veta = str_replace('-', ' ', $text);
        $veta = ucwords($veta);
        $veta = str_replace(' ', '', $veta);
        return $veta;
    }

    private function parsujURL(string $url): array
    {
        $naparsovanaURL = parse_url($url);
        
        // Pokud jsou GET parametry (c=a, a=b), použij je místo path
        if (!empty($_GET['c'])) {
            return [$_GET['c'], $_GET['a'] ?? 'index'];
        }
    
        $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");
        $naparsovanaURL["path"] = trim($naparsovanaURL["path"]);
        $rozdelenaCesta = explode("/", $naparsovanaURL["path"]);
        return $rozdelenaCesta;
    }

    public function zpracuj(array $parametry): void
    {
        $naparsovanaURL = $this->parsujURL($parametry[0]);

        if (empty($naparsovanaURL[0])) {
            $this->presmeruj('uvod');
        }

        if ($naparsovanaURL[0] === 'odhlasit') {
            $this->odhlasUzivatele();
            return;
        }

        $tridaKontroleru = $this->pomlckyDoVelbloudiNotace(array_shift($naparsovanaURL)) . 'Kontroler';

        if (file_exists('kontrolery/' . $tridaKontroleru . '.php')) {
            $this->kontroler = new $tridaKontroleru;
        } else {
            $this->presmeruj('chyba');
        }

        // Zkontroluje, jestli druhý parametr v URL odpovídá metodě kontroleru
        if (!empty($naparsovanaURL[0])) {
            $akce = $naparsovanaURL[0] . 'Action';

            if (method_exists($this->kontroler, $akce)) {
                $this->kontroler->$akce($naparsovanaURL[1] ?? null);
                return; // Ukončí zpracování, protože se jedná o AJAX nebo přímý výstup
            }
        }

        // Pokud akce neexistuje, spustí se defaultní zpracování kontroleru
        $this->kontroler->zpracuj($naparsovanaURL);

        $this->data['titulek'] = $this->kontroler->hlavicka['titulek'];
        $this->data['popis'] = $this->kontroler->hlavicka['popis'];
        $this->data['klicova_slova'] = $this->kontroler->hlavicka['klicova_slova'];

        $this->data['zpravy'] = $this->vratZpravy();

        $this->pohled = 'rozlozeni';
    }

    // Metoda pro odhlášení uživatele přes správce uživatelů
    private function odhlasUzivatele(): void
    {
        $spravceUzivatelu = new SpravceUzivatelu();
        $spravceUzivatelu->odhlas();
        header('Location: /'); // Přesměrování na úvodní stránku
        exit;
    }
}