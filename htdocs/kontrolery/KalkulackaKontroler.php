<?php

class KalkulackaKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        $this->hlavicka = array(
            'titulek' => 'Kalkulačka',
            'klicova_slova' => 'Kalkulačka, cena',
            'popis' => 'Kalkulačka ceny.'
        );

        
        $this->pohled = 'kalkulacka';
    }
}