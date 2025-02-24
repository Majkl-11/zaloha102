<?php

class SablonyKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        // Hlavička stránky
        $this->hlavicka = array(
            'titulek' => 'Šablony',
            'klicova_slova' => 'Šablony, vizitky',
            'popis' => 'Šablony vizitek.'
        );

        $sablonyModel = new SablonyModel();

        // Kontrola, zda je uživatel admin
        $isAdmin = isset($_SESSION['uzivatel']) && $_SESSION['uzivatel']['admin'] == 1;

        // Zpracování nahrání souboru
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['picture'])) {
            if (!$isAdmin) {
                $this->pridejZpravu('Nemáte oprávnění k nahrání šablony.', self::ZPRAVA_CHYBA);
                $this->presmeruj('sablony');
            }

            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? 0;
            $file = $_FILES['picture'];

            if ($file['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'img/';
                $fileName = basename($file['name']);
                $filePath = $uploadDir . $fileName;

                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    $sablonyModel->addTemplate($name, $description, $price, $filePath);
                    $this->pridejZpravu('Šablona byla úspěšně nahrána.', self::ZPRAVA_OK);
                } else {
                    $this->pridejZpravu('Chyba při ukládání souboru.', self::ZPRAVA_CHYBA);
                }
            } else {
                $this->pridejZpravu('Chyba při nahrávání souboru.', self::ZPRAVA_CHYBA);
            }
            $this->presmeruj('sablony');
        }

        // Zpracování mazání šablony (pouze metodou POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            if (!isset($_SESSION['uzivatel']) || $_SESSION['uzivatel']['admin'] != 1) {
                $this->pridejZpravu('Nemáte oprávnění k odstranění šablony.', self::ZPRAVA_CHYBA);
                $this->presmeruj('sablony');
            }
        
            $templateId = (int) $_POST['id'];
        
            $sablonyModel->deleteTemplate($templateId);
            $this->pridejZpravu('Šablona byla úspěšně odstraněna.', self::ZPRAVA_OK);
            $this->presmeruj('sablony');
        }        

        // Načtení šablon
        $sablony = $sablonyModel->getAllTemplates();
        $this->data['sablony'] = $sablony;

        // Nastavení pohledu
        $this->pohled = 'sablony';
    }
}