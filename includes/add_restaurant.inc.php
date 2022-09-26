<?php
declare(strict_types = 1);
include('../actions/action_login.php');
include('../actions/action_add_restaurant.php');
include('../actions/action_upload.php');

include_once('../database/connection.db.php');

$session = new Session;

if(isset($_POST["submit"])){
    if ($_SESSION['csrf'] !== $_POST['csrf']) {
        header("Location: ../index.php");
    }
    $name = $_POST["name"];
    $address = $_POST["address"];
    $restaurantCategory = $_POST["restaurantCategory"];

    echo $restaurantCategory;

    $fileTmpName = $_FILES['image']['tmp_name'];
    $db = getDatabaseConnection();

    //check if all the inputs are filled
    if (emptyFieldsRestaurant($name, $address, $restaurantCategory) !== false){
        header("Location: ../add_restaurant.php?error=emptyinput");
        exit();
    }
    
    if (!isset($_FILES['image']['tmp_name'])) {
        header("Location: ../add_restaurant.php?error=needimage");
        exit();
    }

    $type = photoIsValid($fileTmpName);

    if (!$type) { // check if the given image is jpeg/png
        header("Location: ../add_restaurant.php?error=invalidfile");
        exit();
    }

    $type = extensionToString($type);

    $id = createRestaurant($name, $address, $type, $restaurantCategory, $db, $session);

    uploadPhotoRestaurant($id, $fileTmpName, $type);

    header("location: ../profile.php");
} 

?>