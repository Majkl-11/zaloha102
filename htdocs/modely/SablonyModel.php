<?php

class SablonyModel
{
    public function getAllTemplates(): array
    {
        $db = Db::pripoj();
        $query = "SELECT idcard_template, name, description, price, picture FROM card_template";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTemplate(string $name, string $description, float $price, string $picture): void
    {
        $db = Db::pripoj();
        $query = "INSERT INTO card_template (name, description, price, picture) VALUES (:name, :description, :price, :picture)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':picture' => $picture
        ]);
    }

    public function deleteTemplate(int $id): void
{
    $db = Db::pripoj();
    $query = "DELETE FROM card_template WHERE idcard_template = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}
}