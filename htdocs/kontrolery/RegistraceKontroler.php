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
                $this->pridejZpravu('Byl jste úspěšně zaregistrován.');
                $this->presmeruj('administrace');
            } catch (ChybaUzivatele $chyba) {
                $this->pridejZpravu($chyba->getMessage());
            }
        }

		//test jak to funguje
		if ($_POST) {
			echo '<pre>';
			var_dump($_POST);
			echo '</pre>';
			exit;
		} else {
			echo 'Formulář nebyl odeslán.';
			
		}

        $this->pohled = 'registrace';
    }
}