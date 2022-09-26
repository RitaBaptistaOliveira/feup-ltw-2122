<?php
declare(strict_types = 1);

    function addResponse(PDO $db, int $idCustomer, int $idRestaurant, string $date, string $description, int $rating, string $response){
        $stmt = $db->prepare('UPDATE Review SET response = ? WHERE response IS NULL AND idCustomer = ? AND idRestaurant = ? AND Review.date = ? AND Review.description = ? AND rating = ?;');
        $stmt->execute(array($response, $idCustomer, $idRestaurant, $date, $description, $rating));
    }
?>