<?php
declare(strict_types = 1);
include('../actions/action_login.php');
require_once('../actions/action_upload.php');
include_once('../actions/action_edit_profile.php');

include_once('../database/connection.db.php');

$session = new Session;

if(isset($_POST["submit"])){
    if ($_SESSION['csrf'] !== $_POST['csrf']) {
        header("Location: ../index.php");
    }
    $newUsername = $_POST["username"];
    $newScreenName = $_POST["screenName"];
    $newPassword = $_POST["password"];
    $newPhoneNumber = $_POST["phoneNumber"];
    $newAddress = $_POST["address"];

    $db = getDatabaseConnection();

    updateDatabase($session, $session->getId(),$newUsername, $newScreenName, $newPassword, $newPhoneNumber, $newAddress, $db);

    loginUser($username, $db);

    header("location: ../index.php");
} 
?>