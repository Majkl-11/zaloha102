<?php

class MeasurementModel
{
    // Metoda pro získání všech měření
    public static function getAll(): array
    {
        return Db::dotazVsechny("SELECT * FROM measurement");
    }

    // Metoda pro získání ceny měření podle ID
    public static function getPriceById(int $id): float
    {
        $result = Db::dotazJeden("SELECT price FROM measurement WHERE idmeasurement = ?", [$id]);
        return (float) $result['price'];
    }

    // Metoda pro získání názvu měření podle ID
    public static function getNameById(int $id): string
    {
        $result = Db::dotazJeden("SELECT name FROM measurement WHERE idmeasurement = ?", [$id]);
        return (string) $result['name'];
    }
}