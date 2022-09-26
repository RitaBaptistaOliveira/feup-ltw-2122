<?php
declare(strict_types = 1);
include('../actions/action_add_product.php');
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
    $productCategory = $_POST["productCategory"];

    $fileTmpName = $_FILES['image']['tmp_name'];
    $db = getDatabaseConnection();

    //check if all the inputs are filled
    if (emptyFieldsProduct($name, $address, $productCategory) !== false){
        header("Location: ../add_product.php?error=emptyinput&&idRestaurant<?=$idRestaurant?>");
        echo "name = " . $name;
        echo "price = " . $price; 
        echo "categoria = " . $productCategory; 
        //exit();
    }

    if (!isset($_FILES['image']['tmp_name'])) {
        header("Location: ../add_product.php?error=needimage");
        exit();
    }

    $type = photoIsValid($fileTmpName);

    if (!$type) { // check if the given image is jpeg/png
        header("Location: ../add_product.php?error=invalidfile");
        exit();
    }

    $type = extensionToString($type);

    $id = createProduct($name, $price, $productCategory, $type, $idRestaurant, $db);

    uploadPhotoProduct($id, $fileTmpName, $type);

    header("location: ../profile.php");
} 

?>