<?php


class PrihlaseniKontroler extends Kontroler
{

	public function zpracuj(array $parametry): void
	{
		$spravceUzivatelu = new SpravceUzivatelu();
		if ($spravceUzivatelu->vratUzivatele())
			$this->presmeruj('administrace');
		$this->hlavicka['titulek'] = 'Přihlášení';
		if ($_POST) {
			try {
				$spravceUzivatelu->prihlas($_POST['email'], $_POST['password']);//zmena uzivatel -> email 
				$this->pridejZpravu('Byl jste úspěšně přihlášen.', self::ZPRAVA_OK);
				$this->presmeruj('administrace');
			} catch (ChybaUzivatele $chyba) {
				$this->pridejZpravu($chyba->getMessage(), self::ZPRAVA_CHYBA);
			}
		}
		$this->pohled = 'prihlaseni';
	}
}