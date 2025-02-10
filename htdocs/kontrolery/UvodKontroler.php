<?php
class UvodKontroler extends Kontroler
{
    public function zpracuj(array $parametry): void
    {
        // Nastavení metadat pro stránku
        $this->hlavicka = array(
            'titulek' => 'Úvod',
            'klicova_slova' => 'Úvod, domovská stránka',
            'popis' => 'Úvod našeho webu.'
        );

        // Načtení článku z modelu SpravceClanku podle URL
        $spravceClanku = new SpravceClanku();
        $clanek = $spravceClanku->vratClanek('uvod');
        
        // Předání článku do pohledu
        $this->data = ['clanek' => $clanek];

        // Nastavení pohledu
        $this->pohled = 'uvod';
    }
}
?>