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

        // Zobrazení pohledu
        $this->hlavicka = [
            'titulek' => 'Objednat',
            'klicova_slova' => 'objednat, domovská stránka',
            'popis' => 'Vytvoření objednávky.'
        ];

        $this->pohled = 'objednat';
    }

    // Akce pro výpočet ceny
    public function calculatePriceAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Získání dat z POST requestu
            $quantity = (int) $_POST['quantity'];
            $paperTypeId = (int) $_POST['paperType'];
            $printTypeId = (int) $_POST['printType'];
            $measurementId = (int) $_POST['measurement'];
            $cardTemplateId = (int) $_POST['template'];

            // Získání cen z modelů
            $paperTypePrice = PaperTypeModel::getPriceById($paperTypeId);
            $printTypePrice = PrintModel::getPriceById($printTypeId);
            $measurementPrice = MeasurementModel::getPriceById($measurementId);
            $cardTemplatePrice = CardTemplateModel::getPriceById($cardTemplateId);

            // Výpočet ceny
            $price = ($paperTypePrice + $printTypePrice + $measurementPrice + $cardTemplatePrice) * $quantity;

            // Připočítání DPH
            $priceWithVat = $price * 1.21;

            // Výstup ceny ve formátu JSON
            echo json_encode(['price' => number_format($priceWithVat, 2, '.', '')]);
        }
    }

    // Akce pro vytvoření objednávky
    public function createOrderAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kontrola, zda jsou všechna potřebná data v POST requestu
            if (
                empty($_POST['quantity']) ||
                empty($_POST['template']) ||
                empty($_POST['paperType']) ||
                empty($_POST['printType']) ||
                empty($_POST['measurement']) ||
                empty($_POST['price'])
            ) {
                echo json_encode(["success" => false, "message" => "Chybí některé údaje!"]);
                return;
            }

            // Načtení dat z POST requestu
            $quantity = (int) $_POST['quantity'];
            $idCardTemplate = (int) $_POST['template'];
            $idPaperType = (int) $_POST['paperType'];
            $idPrint = (int) $_POST['printType'];
            $idMeasurement = (int) $_POST['measurement'];
            $price = (float) $_POST['price'];

            // Kontrola hodnot (musí být větší než 0)
            if ($quantity <= 0 || $price <= 0) {
                $this->pridejZpravu('Neplatné údaje.', self::ZPRAVA_CHYBA);
                return;
            }

            // Zavolání metody z modelu pro uložení objednávky
            $orderId = OrderModel::createOrder($quantity, $idCardTemplate, $idPaperType, $idPrint, $idMeasurement, $price);

            // Odpověď klientovi
            if ($orderId) {
                $this->pridejZpravu('Objednávka byla vytořena.', self::ZPRAVA_OK);
            } else {
                $this->pridejZpravu('Chyba při ukládání objednávky.', self::ZPRAVA_CHYBA);
            }
        }
    }
}