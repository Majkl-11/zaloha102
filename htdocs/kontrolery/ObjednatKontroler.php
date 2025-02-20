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
            exit;
        }
    }

    // Akce pro vytvoření objednávky
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
                echo json_encode(['success' => true, 'order_id' => $orderId, 'message' => 'Objednávka byla úspěšně vytvořena!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Chyba při ukládání objednávky.']);
            }
            exit;
        }
    }
}