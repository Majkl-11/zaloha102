<?php


class AdministraceKontroler extends Kontroler
{
	/*public function zpracuj(array $parametry): void
	{
		$this->overUzivatele();
		$this->hlavicka['titulek'] = 'Přihlášení';
		$spravceUzivatelu = new SpravceUzivatelu();
		if (!empty($parametry[0]) && $parametry[0] == 'odhlasit') {
			$spravceUzivatelu->odhlas();
			$this->presmeruj('prihlaseni');
		}
		$uzivatel = $spravceUzivatelu->vratUzivatele();
		$this->data['jmeno'] = $uzivatel['jmeno'];
		$this->data['admin'] = $uzivatel['admin'];
		$this->pohled = 'administrace';
	}*/

	public function zpracuj(array $parametry): void
    {
        $this->overUzivatele(); // Zkontroluje, zda je uživatel přihlášen
       
        $spravceUzivatelu = new SpravceUzivatelu();
        $uzivatel = $spravceUzivatelu->vratUzivatele();

        // Hlavička stránky
        $this->hlavicka['titulek'] = 'Administrace';
        $this->data['jmeno'] = $uzivatel['jmeno'] ?? '';
        $this->data['email'] = $uzivatel['email'] ?? '';
        $this->data['admin'] = $uzivatel['admin'] ?? false;


        // Nastavení šablony
        $this->pohled = 'administrace';
    }
}