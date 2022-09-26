<?php
declare(strict_types = 1);
include_once('../actions/action_edit_state.php');

include_once('../database/connection.db.php');

if(isset($_POST["submit"])){
    if ($_SESSION['csrf'] !== $_POST['csrf']) {
        header("Location: ../index.php");
    }
    $orderState = $_POST["orderState"];
    $idOrder = $_POST["idOrder"];

    $db = getDatabaseConnection();

    updateDatabase($idOrder, $orderState, $db);

    header("location: ../index.php");
} 
?>