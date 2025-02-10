<?php

class ObjednatKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        $this->hlavicka = array(
            'titulek' => 'Objednat',
            'klicova_slova' => 'objednat, domovská stránka',
            'popis' => 'Vytvoření objednávky.'
        );

        $this->pohled = 'objednat';
    }
}