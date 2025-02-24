<?php

class UzivateleModel
{
    public function getAllUsers(): array
    {
        $db = Db::pripoj();
        $query = "SELECT iduser, name, email, admin FROM user";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function smazUzivatele(int $iduser): void
    {
        $db = Db::pripoj();
        $query = "DELETE FROM user WHERE iduser = :iduser";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':iduser', $iduser, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function zmenAdminPrava(int $iduser, int $admin): void
    {
        $db = Db::pripoj();
        $query = "UPDATE user SET admin = :admin WHERE iduser = :iduser";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':iduser', $iduser, PDO::PARAM_INT);
        $stmt->bindParam(':admin', $admin, PDO::PARAM_INT);
        $stmt->execute();
    }
}
