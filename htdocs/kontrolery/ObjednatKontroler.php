<?php

class ObjednatKontroler extends Kontroler
{

        

    public function zpracuj(array $parametry): void
    {

        // Získání dat pro papíry, tisk a rozměry
        $this->cardTemplates = CardTemplateModel::getAll();
        $this->paperTypes = PaperTypeModel::getAll(); // Model pro papíry
        $this->printTypes = PrintModel::getAll(); // Model pro tisk
        $this->measurements = MeasurementModel::getAll(); // Model pro rozměry

        // Zobrazení pohledu
        $this->hlavicka = array(
            'titulek' => 'Objednat',
            'klicova_slova' => 'objednat, domovská stránka',
            'popis' => 'Vytvoření objednávky.'
        );

        $this->pohled = 'objednat';
    }
    
    // Akce pro výpočet ceny
    public function calculatePriceAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantity = $_POST['quantity'];
            $paperTypeId = $_POST['paperType'];
            $printTypeId = $_POST['printType'];
            $dimensionId = $_POST['dimension'];

            // Získání cen z modelů
            $paperTypePrice = PaperTypeModel::getPriceById($paperTypeId);
            $printTypePrice = PrintModel::getPriceById($printTypeId);
            $dimensionPrice = MeasurementModel::getPriceById($dimensionId);

            // Výpočet ceny
            $price = ($paperTypePrice + $printTypePrice + $dimensionPrice) * $quantity;

            // Připočítání DPH
            $priceWithVat = $price * 1.21;

            // Výstup ceny
            echo number_format($priceWithVat, 2);
        }
    }


}