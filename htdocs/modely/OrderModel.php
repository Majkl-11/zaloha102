<?php

class OrderModel
{
    public static function createOrder($quantity, $idCardTemplate, $idPaperType, $idPrint, $idMeasurement, $price)
    {
        $db = Db::pripoj();
        $sql = "INSERT INTO `order` (order_date, price, quantity, idcard_template, idpaper_type, idprint, idmeasurement)
                VALUES (NOW(), :price, :quantity, :idcard_template, :idpaper_type, :idprint, :idmeasurement)";
        
        $dotaz = $db->prepare($sql);
        $dotaz->bindValue(":price", $price, PDO::PARAM_STR);
        $dotaz->bindValue(":quantity", $quantity, PDO::PARAM_INT);
        $dotaz->bindValue(":idcard_template", $idCardTemplate, PDO::PARAM_INT);
        $dotaz->bindValue(":idpaper_type", $idPaperType, PDO::PARAM_INT);
        $dotaz->bindValue(":idprint", $idPrint, PDO::PARAM_INT);
        $dotaz->bindValue(":idmeasurement", $idMeasurement, PDO::PARAM_INT);
        $dotaz->execute();

        return $db->lastInsertId();
    }
}
