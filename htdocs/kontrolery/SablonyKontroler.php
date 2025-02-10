<?php

class SablonyKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        // Hlavička stránky
        $this->hlavicka = array(
            'titulek' => 'Šablony',
            'klicova_slova' => 'Šablony, vizitky,',
            'popis' => 'Šablony vizitek.'
        );

        // Načtení dat z modelu
        $sablonyModel = new SablonyModel();
        $sablony = $sablonyModel->getAllTemplates();

        // Předání dat do pohledu
        $this->data['sablony'] = $sablony;

        // Nastavení pohledu
        $this->pohled = 'sablony';
    }
}