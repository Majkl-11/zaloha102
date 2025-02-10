<?php

class ObchodnipodminkyKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        $this->hlavicka = array(
            'titulek' => 'Obchodní podmínky',
            'klicova_slova' => 'obchod, podmínky',
            'popis' => 'Obchodní podmínky našeho obchodu.'
        );

                // Načtení článku z modelu SpravceClanku podle URL
                $spravceClanku = new SpravceClanku();
                $clanek = $spravceClanku->vratClanek('obchodnipodminky');
                
                // Předání článku do pohledu
                $this->data = ['clanek' => $clanek];

        $this->pohled = 'obchodnipodminky';
    }
}