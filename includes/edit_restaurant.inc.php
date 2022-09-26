<?php
declare(strict_types = 1);
include('../actions/action_login.php');
require_once('../actions/action_add_restaurant.php');
include_once('../actions/action_edit_restaurant.php');

include_once('../database/connection.db.php');

if(isset($_POST["submit"])){
    if ($_SESSION['csrf'] !== $_POST['csrf']) {
        header("Location: ../index.php");
    }
    $newName = $_POST["name"];
    $newAddress = $_POST["address"];
    $newCategory = $_POST["restaurantCategory"];
    $id = $_POST["idRestaurant"];

    if(emptyFieldsRestaurant($newName, $newAddress, $newCategory)){
        header("location: ../edit_restaurant.php?error=emptyfields");
        exit();
    }

    $db = getDatabaseConnection();

    updateDatabase($id, $newName, $newAddress, $newCategory, $db);

    header("location: ../profile.php");
} 
?>