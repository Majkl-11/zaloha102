<?php

class ObjednavkyKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        // Hlavička stránky
        $this->hlavicka = array(
            'titulek' => 'Správa objednávek',
            'klicova_slova' => 'Správa, objednávek, administrace',
            'popis' => 'Administrace objednávek.'
        );

        $objednavkyModel = new ObjednavkyModel();

        // Kontrola, zda je uživatel admin
        if (!isset($_SESSION['uzivatel']) || $_SESSION['uzivatel']['admin'] != 1) {
            $this->pridejZpravu('Nemáte oprávnění k této akci.', self::ZPRAVA_CHYBA);
            $this->presmeruj('prihlaseni');
        }
       
        // Zpracování smazání objednávky (pouze metodou POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['smazat'])) {
            $idorder = (int) $_POST['idorder'];
            if ($idorder) { 
                $objednavkyModel->smazObjednavku($idorder);
                $this->pridejZpravu('Objednávka byla úspěšně odstraněna.', self::ZPRAVA_OK);
            }
            $this->presmeruj('objednavky');
        }

        // Načtení seznamu objednávek
        $this->data['seznamObjednavek'] = $objednavkyModel->getAllOrders();

        // Nastavení pohledu
        $this->pohled = 'objednavky';
    }
}
