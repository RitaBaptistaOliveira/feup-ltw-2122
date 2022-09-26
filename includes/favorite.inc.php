<?php
declare(strict_types = 1);
include('../actions/action_addFavorite.php');

include_once('../utils/session.php');
include_once('../database/connection.db.php');

if(isset($_POST["submit"])){
    $db = getDatabaseConnection();
    if ($_SESSION['csrf'] !== $_POST['csrf']) {
        header("Location: ../index.php");
    }
    $value = $_POST['place'];
    $id = intval($_POST['id']);
    $idRestaurant = intval($_POST['idRestaurant']);

    addFavorite($db, $value, $id);

    header("location: ../restaurant.php?id=".$idRestaurant."&success=yes");
} 

?>