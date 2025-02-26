<?php

class ObjednatKontroler extends Kontroler
{ 
    public $cardTemplates;
    public $paperTypes;
    public $printTypes;
    public $measurements;

    public function zpracuj(array $parametry): void
    {
        $this->cardTemplates = CardTemplateModel::getAll();
        $this->paperTypes = PaperTypeModel::getAll();
        $this->printTypes = PrintModel::getAll();
        $this->measurements = MeasurementModel::getAll();

        $this->hlavicka = [
            'titulek' => 'Objednat',
            'klicova_slova' => 'objednat, tisk, vizitky',
            'popis' => 'Vytvoření objednávky pro tisk vizitek.'
        ];

        $this->pohled = 'objednat';
    }

    public function calculatePriceAction(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 0;
            $paperTypeId = isset($_POST['paperType']) ? (int) $_POST['paperType'] : 0;
            $printTypeId = isset($_POST['printType']) ? (int) $_POST['printType'] : 0;
            $measurementId = isset($_POST['measurement']) ? (int) $_POST['measurement'] : 0;
            $cardTemplateId = isset($_POST['template']) ? (int) $_POST['template'] : 0;

            $paperTypePrice = PaperTypeModel::getPriceById($paperTypeId);
            $printTypePrice = PrintModel::getPriceById($printTypeId);
            $measurementPrice = MeasurementModel::getPriceById($measurementId);
            $cardTemplatePrice = CardTemplateModel::getPriceById($cardTemplateId);

            if ($quantity > 0 && $paperTypePrice && $printTypePrice && $measurementPrice && $cardTemplatePrice) {
                $price = ($paperTypePrice + $printTypePrice + $measurementPrice + $cardTemplatePrice) * $quantity;
                $priceWithVat = $price * 1.21;

                echo json_encode(['success' => true, 'price' => number_format($priceWithVat, 2, '.', '')]);
                return;
            }
        }

        $this->pridejZpravu('Neplatné vstupní údaje', self::ZPRAVA_CHYBA);
    }

    public function createOrderAction(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (
                empty($_POST['quantity']) ||
                empty($_POST['template']) ||
                empty($_POST['paperType']) ||
                empty($_POST['printType']) ||
                empty($_POST['measurement']) ||
                empty($_POST['price']) ||
                empty($_POST['companyName']) ||
                empty($_POST['phoneNumber']) ||
                empty($_POST['email']) ||
                empty($_FILES['logo'])
            ) {
                $this->pridejZpravu('Chybí některé údaje!', self::ZPRAVA_CHYBA);
                return;
            }

            $quantity = (int) $_POST['quantity'];
            $idCardTemplate = (int) $_POST['template'];
            $idPaperType = (int) $_POST['paperType'];
            $idPrint = (int) $_POST['printType'];
            $idMeasurement = (int) $_POST['measurement'];
            $price = (float) $_POST['price'];
            $companyName = trim($_POST['companyName']);
            $phoneNumber = trim($_POST['phoneNumber']);
            $email = trim($_POST['email']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->pridejZpravu('Neplatný formát e-mailu!', self::ZPRAVA_CHYBA);
                return;
            }

            if (!preg_match('/^[0-9\+\-\s]+$/', $phoneNumber)) {
                $this->pridejZpravu('Neplatný formát telefonního čísla!', self::ZPRAVA_CHYBA);
                return;
            }

            $logoPath = "";
            if ($_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $allowedTypes = ['image/png', 'image/jpeg', 'image/gif'];
                $fileType = mime_content_type($_FILES['logo']['tmp_name']);

                if (!in_array($fileType, $allowedTypes)) {
                    $this->pridejZpravu('Neplatný formát loga! Použijte PNG, JPG nebo GIF.', self::ZPRAVA_CHYBA);
                    return;
                }

                $uploadDir = "logo/";
                $fileName = time() . "_" . basename($_FILES["logo"]["name"]);
                $logoPath = $uploadDir . $fileName;

                if (!move_uploaded_file($_FILES["logo"]["tmp_name"], $logoPath)) {
                    $this->pridejZpravu('Chyba při nahrávání souboru!', self::ZPRAVA_CHYBA);
                    return;
                }
            } else {
                $this->pridejZpravu('Musíte nahrát logo!', self::ZPRAVA_CHYBA);
                return;
            }

            $orderId = OrderModel::createOrder($quantity, $idCardTemplate, $idPaperType, $idPrint, $idMeasurement, $price, $logoPath, $companyName, $phoneNumber, $email);

            require_once 'mailer_objednavka.php';
                if ($orderId) {
                    if (sendOrderEmail($email, $orderId, $quantity, $price, $companyName, $phoneNumber)) {
                        $this->pridejZpravu('Objednávka byla vytvořena, potvrzovací e-mail byl odeslán.', self::ZPRAVA_OK);
                    } else {
                        $this->pridejZpravu('Objednávka byla vytvořena, ale e-mail se nepodařilo odeslat.', self::ZPRAVA_CHYBA);
                    }
                    } else {
                        $this->pridejZpravu('Chyba při ukládání objednávky.', self::ZPRAVA_CHYBA);
                    }
            
        }
    }
}

/*
require_once 'mailer_registrace.php';
                if (odeslatRegistracniEmail($email, $jmeno)) {
                    $this->pridejZpravu('Byl jste úspěšně zaregistrován.', self::ZPRAVA_OK);
                } else {
                    $this->pridejZpravu('Registrace proběhla, ale e-mail se nepodařilo odeslat.', self::ZPRAVA_INFO);
                }
*/

