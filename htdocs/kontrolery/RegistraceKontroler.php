<?php

class RegistraceKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        $this->hlavicka['titulek'] = 'Registrace';

        if ($_POST) {
            try {
                $jmeno = $_POST['jmeno'] ?? null;
                $email = $_POST['email'] ?? null;
                $heslo = $_POST['heslo'] ?? null;
                $hesloZnovu = $_POST['heslo_znovu'] ?? null;
                $rok = $_POST['rok'] ?? null;

                if (!$jmeno || !$email || !$heslo || !$hesloZnovu || !$rok) {
                    throw new ChybaUzivatele('Všechny pole musí být vyplněny.');
                }

                $spravceUzivatelu = new SpravceUzivatelu();
                $spravceUzivatelu->registruj($jmeno, $email, $heslo, $hesloZnovu, $rok);
                $spravceUzivatelu->prihlas($email, $heslo);

                // Zavolání maileru
                require_once 'mailer/mailer_registrace.php';
                if (odeslatRegistracniEmail($email, $jmeno)) {
                    $this->pridejZpravu('Byl jste úspěšně zaregistrován.', self::ZPRAVA_OK);
                } else {
                    $this->pridejZpravu('Registrace proběhla, ale e-mail se nepodařilo odeslat.', self::ZPRAVA_INFO);
                }

                $this->presmeruj('administrace');
            } catch (ChybaUzivatele $chyba) {
                $this->pridejZpravu($chyba->getMessage(), self::ZPRAVA_CHYBA);
            }
        }

        $this->pohled = 'registrace';
    }
}