<?php
declare(strict_types = 1);
include('../actions/action_addResponse.php');

include('../utils/session.php');
include_once('../database/connection.db.php');


if(isset($_POST["submit"])){
    $session = new Session();
    $id = $session->getId();

    $response = $_POST['response'];
    $idRestaurant = intval($_POST['restaurant']);
    $idCustomer = intval($_POST['user']);
    $rating = intval($_POST['rating']);
    $date = $_POST['date'];
    $description = $_POST['description'];

    $db = getDatabaseConnection();
    
    
    addResponse($db, $idCustomer, $idRestaurant, $date, $description, $rating, $response);

    header("location: ../profile.php?id=".$id."&success=yes");
} 

?>