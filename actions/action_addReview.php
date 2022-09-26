<?php
declare(strict_types = 1);

    function checkOrders(PDO $db, int $idUser, int $idRestaurant) : bool{
        $stmt = $db->prepare('SELECT * FROM Purchase WHERE idCustomer = ?');
        $stmt->execute(array($idUser));

        $result = $stmt->fetchAll();

        if (count($result) > 0) {
            return true; //the username is already being used
        } else {
            return false; //the username is valid
        }
    } 

    function emptyFieldsRegister($score, $reviewText) : bool{
        if(empty($score) || empty($reviewText)){
            return true; //if any of the fields is empty
        }
        return false; //if all the fields are filled in
     }

    function addReview(PDO $db, int $idUser, int $idRestaurant, string $reviewText, int $score){
        $stmt = $db->prepare("INSERT INTO Review VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(array($idUser, $idRestaurant, date("d/m/Y"), $reviewText, $score));     
    }
?>