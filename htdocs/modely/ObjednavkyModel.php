<?php

class ObjednavkyModel
{
    public function getAllOrders(): array
    {
        $db = Db::pripoj();
        $query = "SELECT idorder, order_date, price, quantity, idcard_template, idpaper_type, idprint, idmeasurement, email, company_name, phone_number, logo FROM `order`";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function smazObjednavku(int $idorder): void
    {
        $db = Db::pripoj();
        $query = "DELETE FROM `order` WHERE idorder = :idorder";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':idorder', $idorder, PDO::PARAM_INT);
        $stmt->execute();
    }
}
