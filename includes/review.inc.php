<?php
declare(strict_types = 1);
include('../actions/action_addReview.php');

include_once('../utils/session.php');
include_once('../database/connection.db.php');

if(isset($_POST["submit"])){
    if ($_SESSION['csrf'] !== $_POST['csrf']) {
        header("Location: ../index.php");
    }
    $reviewText = $_POST["reviewText"];
    $score = $_POST["score"];
    $idRestaurant = $_POST["id"];

    $db = getDatabaseConnection();
    $session = new Session();

    $idUser = $session->getID();

    //check if all the inputs are filled
    if(!$session->isLoggedIn()){
        header("Location: ../restaurant.php?id=".$idRestaurant."&error=notloggedin");
        exit();
    }

    if (emptyFieldsRegister($score, $reviewText) !== false){
        header("Location: ../restaurant.php?id=".$idRestaurant."&error=emptyinput");
        exit();
    }

    if(checkOrders($db, $idUser, $idRestaurant)){
        header("Location: ../restaurant.php?id=".$idRestaurant."&error=noorder");
        exit();
    }

    addReview($db, $idUser, $idRestaurant, $reviewText, $score);

    header("location: ../restaurant.php?id=".$idRestaurant."&error=none");
} 

?>