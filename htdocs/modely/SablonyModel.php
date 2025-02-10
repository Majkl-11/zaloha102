<?php

class SablonyModel
{
    public function getAllTemplates(): array
    {
        // Připojení k databázi s potřebnými argumenty
        $db = Db::pripoj('localhost', 'root', '', 'mydb');

        $query = "SELECT idcard_template, name, description, picture FROM card_template";
        $stmt = $db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}