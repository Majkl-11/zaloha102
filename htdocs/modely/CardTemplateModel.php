<?php

class CardTemplateModel
{
    // Metoda pro získání všech šablon
    public static function getAll(): array
    {
        return Db::dotazVsechny("SELECT * FROM card_template");
    }

    // Metoda pro získání ceny šablony podle ID
    public static function getPriceById(int $id): float
    {
        $result = Db::dotazJeden("SELECT price FROM card_template WHERE idcard_template = ?", [$id]);
        return (float) $result['price'];
    }

    // Metoda pro získání názvu šablony podle ID
    public static function getNameById(int $id): string
    {
        $result = Db::dotazJeden("SELECT name FROM card_template WHERE idcard_template = ?", [$id]);
        return (string) $result['name'];
    }

    // Metoda pro získání cesty k obrázku šablony podle ID
    public static function getImageById(int $id): string
    {
        $result = Db::dotazJeden("SELECT picture FROM card_template WHERE idcard_template = ?", [$id]);
        return (string) $result['picture'];
    }
}