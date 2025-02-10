<?php

class SluzbyKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        $this->hlavicka = array(
            'titulek' => 'Služby',
            'klicova_slova' => 'služby, nabídky',
            'popis' => 'Služby našeho webu.'
        );

                       // Načtení článku z modelu SpravceClanku podle URL
                       $spravceClanku = new SpravceClanku();
                       $clanek = $spravceClanku->vratClanek('sluzby');
                       
                       // Předání článku do pohledu
                       $this->data = ['clanek' => $clanek];

        $this->pohled = 'sluzby';
    }
}