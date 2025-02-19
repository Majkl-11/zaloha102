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
        //die("ObjednatKontroler byl zavolán!");
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
<<<<<<< Updated upstream
            $quantity = $_POST['quantity'];
            $paperTypeId = $_POST['paperType'];
            $printTypeId = $_POST['printType'];
            $measurementId = $_POST['measurement'];
=======
            // Získání dat z POST requestu
            $quantity = (int) $_POST['quantity'];
            $paperTypeId = (int) $_POST['paperType'];
            $printTypeId = (int) $_POST['printType'];
            $measurementId = (int) $_POST['measurement'];
            $cardTemplateId = (int) $_POST['template'];
>>>>>>> Stashed changes

            // Získání cen z modelů
            $paperTypePrice = PaperTypeModel::getPriceById($paperTypeId);
            $printTypePrice = PrintModel::getPriceById($printTypeId);
            $measurementPrice = MeasurementModel::getPriceById($measurementId);
<<<<<<< Updated upstream
            $cardTemplatePrice = CardTemplateModel::getPriceById($measurementId);
=======
            $cardTemplatePrice = CardTemplateModel::getPriceById($cardTemplateId);
>>>>>>> Stashed changes

            // Výpočet ceny
            $price = ($paperTypePrice + $printTypePrice + $measurementPrice + $cardTemplatePrice) * $quantity;

            // Připočítání DPH
            $priceWithVat = $price * 1.21;
<<<<<<< Updated upstream
            
            // Výstup ceny
            echo number_format($priceWithVat, 2);
=======

            // Výstup ceny ve formátu JSON
            echo json_encode(['price' => number_format($priceWithVat, 2, '.', '')]);
            exit; 
>>>>>>> Stashed changes
        }
    }

    public function createOrderAction(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $quantity = (int) $_POST['quantity'];
        $idCardTemplate = (int) $_POST['template'];
        $idPaperType = (int) $_POST['paperType'];
        $idPrint = (int) $_POST['printType'];
        $idMeasurement = (int) $_POST['measurement'];
        $price = (float) $_POST['price'];

        // Zavolání metody z modelu pro uložení objednávky
        $orderId = OrderModel::createOrder($quantity, $idCardTemplate, $idPaperType, $idPrint, $idMeasurement, $price);

        if ($orderId) {
            echo json_encode(['success' => true, 'order_id' => $orderId]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Chyba při ukládání objednávky.']);
        }
        exit;
    }
}
}