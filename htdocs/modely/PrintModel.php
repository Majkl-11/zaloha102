<?php

class PrintModel
{
    // Metoda pro získání všech tisků
    public static function getAll(): array
    {
        return Db::dotazVsechny("SELECT * FROM print");
    }

    // Metoda pro získání ceny tisku podle ID
    public static function getPriceById(int $id): float
    {
        $result = Db::dotazJeden("SELECT price FROM print WHERE idprint = ?", [$id]);
        return (float) $result['price'];
    }

    // Metoda pro získání názvu tisku podle ID
    public static function getNameById(int $id): string
    {
        $result = Db::dotazJeden("SELECT name FROM print WHERE idprint = ?", [$id]);
        return (string) $result['name'];
    }
}