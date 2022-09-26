<?php
declare(strict_types = 1);

    function addFavorite(PDO $db, string $value, $id){
        $session = new Session(); 
        $idUser = $session->getID();
        if($value == "product"){
            $stmt = $db->prepare("INSERT INTO FavoriteProduct VALUES (?, ?)");
            $stmt->execute(array($idUser, $id)); 
        }
        else if($value == "menu"){
            $stmt = $db->prepare("INSERT INTO FavoriteMenu VALUES (?, ?)");
            $stmt->execute(array($idUser, $id)); 
        }
        else if($value == "restaurant"){
            $stmt = $db->prepare("INSERT INTO FavoriteRestaurant VALUES (?, ?)");
            $stmt->execute(array($idUser, $id)); 
        }
    }
?>