<?php

class PaperTypeModel
{
    // Metoda pro získání všech papírů
    public static function getAll(): array
    {
        return Db::dotazVsechny("SELECT * FROM paper_type");
    }

    // Metoda pro získání ceny papíru podle ID
    public static function getPriceById(int $id): float
    {
        $result = Db::dotazJeden("SELECT price FROM paper_type WHERE idpaper_type = ?", [$id]);
        return (float) $result['price'];
    }

    // Metoda pro získání názvu papíru podle ID
    public static function getNameById(int $id): string
    {
        $result = Db::dotazJeden("SELECT name FROM paper_type WHERE idpaper_type = ?", [$id]);
        return (string) $result['name'];
    }
}