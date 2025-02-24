<?php

class UzivateleKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        // Hlavička stránky
        $this->hlavicka = array(
            'titulek' => 'Správa uživatelů',
            'klicova_slova' => 'Správa, uživatelé, administrace',
            'popis' => 'Administrace uživatelských účtů.'
        );

        $uzivateleModel = new UzivateleModel();

        // Kontrola, zda je uživatel admin
        if (!isset($_SESSION['uzivatel']) || $_SESSION['uzivatel']['admin'] != 1) {
            $this->pridejZpravu('Nemáte oprávnění k této akci.', self::ZPRAVA_CHYBA);
            $this->presmeruj('prihlaseni');
        }

        // Zpracování změny admin práv
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['zmenit_prava'])) {
            $iduser = (int) $_POST['iduser'];
            $admin = (int) $_POST['admin'];
            if ($iduser !== $_SESSION['uzivatel']['iduser']) { // Zabránění změny vlastních práv
                $uzivateleModel->zmenAdminPrava($iduser, $admin);
                $this->pridejZpravu('Práva uživatele byla úspěšně změněna.', self::ZPRAVA_OK);
            } else {
                $this->pridejZpravu('Nemůžete změnit vlastní administrátorská práva.', self::ZPRAVA_CHYBA);
            }
            $this->presmeruj('uzivatele');
        }

        // Zpracování smazání uživatele (pouze metodou POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['smazat'])) {
            $iduser = (int) $_POST['iduser'];
            if ($iduser !== $_SESSION['uzivatel']['iduser']) { // Zabránění smazání sebe sama
                $uzivateleModel->smazUzivatele($iduser);
                $this->pridejZpravu('Uživatel byl úspěšně odstraněn.', self::ZPRAVA_OK);
            } else {
                $this->pridejZpravu('Nemůžete smazat sami sebe.', self::ZPRAVA_CHYBA);
            }
            $this->presmeruj('uzivatele');
        }

        // Načtení seznamu uživatelů
        $this->data['seznamUzivatelu'] = $uzivateleModel->getAllUsers();

        // Nastavení pohledu
        $this->pohled = 'uzivatele';
    }
}
