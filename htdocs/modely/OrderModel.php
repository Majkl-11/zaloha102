<?php

class OrderModel
{
    public static function createOrder($quantity, $idCardTemplate, $idPaperType, $idPrint, $idMeasurement, $price, $logoPath, $companyName, $phoneNumber, $email)
    {
        $db = Db::pripoj();
        $sql = "INSERT INTO `order` (order_date, price, quantity, idcard_template, idpaper_type, idprint, idmeasurement, logo, company_name, phone_number, email)
                VALUES (NOW(), :price, :quantity, :idcard_template, :idpaper_type, :idprint, :idmeasurement, :logo, :company_name, :phone_number, :email)";
        
        $dotaz = $db->prepare($sql);
        $dotaz->bindValue(":price", $price, PDO::PARAM_STR);
        $dotaz->bindValue(":quantity", $quantity, PDO::PARAM_INT);
        $dotaz->bindValue(":idcard_template", $idCardTemplate, PDO::PARAM_INT);
        $dotaz->bindValue(":idpaper_type", $idPaperType, PDO::PARAM_INT);
        $dotaz->bindValue(":idprint", $idPrint, PDO::PARAM_INT);
        $dotaz->bindValue(":idmeasurement", $idMeasurement, PDO::PARAM_INT);
        $dotaz->bindValue(":logo", $logoPath, PDO::PARAM_STR);
        $dotaz->bindValue(":company_name", $companyName, PDO::PARAM_STR);
        $dotaz->bindValue(":phone_number", $phoneNumber, PDO::PARAM_STR);
        $dotaz->bindValue(":email", $email, PDO::PARAM_STR);
        $dotaz->execute();

        return $db->lastInsertId();
    }
}

