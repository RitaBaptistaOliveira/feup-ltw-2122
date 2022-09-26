<?php
declare(strict_types = 1);
include('../actions/action_add_menu.php');
include('../actions/action_upload.php');

include_once('../database/connection.db.php');

require_once('../utils/session.php');

$session = new Session;

if(isset($_POST["submit"])){
    if ($_SESSION['csrf'] !== $_POST['csrf']) {
        header("Location: ../index.php");
    }
    $name = $_POST["name"];
    $price = $_POST["price"];
    $idRestaurant = $_POST["idRestaurant"];

    $fileTmpName = $_FILES['image']['tmp_name'];
    $db = getDatabaseConnection();

    //check if all the inputs are filled
    if (emptyFieldsMenu($name, $address) !== false){
        header("Location: ../add_menu.php?error=emptyinput&&idRestaurant<?=$idRestaurant?>");
        //exit();
    }

    if (!isset($_FILES['image']['tmp_name'])) {
        header("Location: ../add_menu.php?error=needimage");
        exit();
    }

    $type = photoIsValid($fileTmpName);

    if (!$type) { // check if the given image is jpeg/png
        header("Location: ../add_menu.php?error=invalidfile");
        exit();
    }

    $type = extensionToString($type);

    $id = createMenu($name, $price, $type, $idRestaurant, $db);

    uploadPhotoMenu($id, $fileTmpName, $type);

    header("location: ../profile.php");
} 

?>