<?php
    declare(strict_types = 1);

    require_once('/database/connection.db.php');

    $session = new Session();
    $db = getDatabaseConnection();

    if($_SESSION['cart'][$_POST['id']]){
        $_SESSION['cart'][$_POST['id']]['quantity'] = $_SESSION['cart'][$_POST['id']]['quantity'] + $_POST['quantity'];
    }
    else{
        $_SESSION['cart'][$_POST['id']]['quantity'] = $_POST['quantity'];
        $_SESSION['cart'][$_POST['id']]['price'] = $_POST['price'];
        $_SESSION['cart'][$_POST['id']]['idR'] = $_POST['idR'];
    }

    header("Location:".$_SERVER['HTTP_REFERER']."");
?>
