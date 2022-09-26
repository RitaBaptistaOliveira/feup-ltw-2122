<?php
require_once("../actions/action_register.php");
include_once("utils/session.php");

function updateDatabase($id, $newName, $newAddress, $newCategory, PDO $db){

    $stmt = $db->prepare('UPDATE Restaurant 
    SET name = ?, address = ?, idCategory = ? WHERE idRestaurant = ? ');
    $stmt->execute(array($newName, $newAddress, $newCategory, $id));

}
?>