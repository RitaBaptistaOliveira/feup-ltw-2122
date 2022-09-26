<?php
declare(strict_types = 1);
include('../actions/action_login.php');
include('../actions/action_register.php');
include('../actions/action_upload.php');
//include('functions.inc.php');

include_once('../database/connection.db.php');


if(isset($_POST["submit"])){
    if ($_SESSION['csrf'] !== $_POST['csrf']) {
        header("Location: ../index.php");
    }
    $username = $_POST["username"];
    $screenName = $_POST["screenName"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["passwordRepeat"];
    $phonenumber = $_POST["phonenumber"];
    $address = $_POST["address"];
    $userType = $_POST["userType"];

    $fileTmpName = $_FILES['image']['tmp_name'];
    $db = getDatabaseConnection();

    //check if all the inputs are filled
    if (emptyFieldsRegister($username, $screenName, $password, $phonenumber, $address) !== false){
        header("Location: ../register.php?error=emptyinput");
        exit();
    }

    //check if the username is valid
    if (invalidUsername($username) !== false){
        header("Location: ../register.php?error=invalidusername");
        exit();
    }

     //check if the username is taken
    if (takenUsername($username, $db) !== false){
        header("Location: ../register.php?error=takenusername");
        exit();
    }

    //check if the phone number is valid
    if (invalidPhoneNumber($phonenumber) !== false){
        header("Location: ../register.php?error=invalidphonenumber");
        exit();
    }

    //check if the phone number is taken
    if (takenPhoneNumber($phonenumber, $db) !== false){
        header("Location: ../register.php?error=takenphonenumber");
        exit();
    }

    if(!samePassword($password, $passwordRepeat)){
        header("Location: ../register.php?error=passwordsdontmatch");
        exit();
    }
    
    if (!isset($_FILES['image']['tmp_name'])) {
        header("Location: ../register.php?error=needimage");
        exit();
    }

    $type = photoIsValid($fileTmpName);

    if (!$type) { // check if the given image is jpeg/png
        header("Location: ../register.php?error=invalidfile");
        exit();
    }

    $type = extensionToString($type);

    $id = createUser($username, $screenName, $password, $phonenumber, $type, $address, $db);

    echo $id;

    uploadPhotoUser($id, $fileTmpName, $type);

    if($userType === "restaurantOwner"){
        createRestaurantOwner($id, $db);
        
    }
    else{
        createCustomer($id, $db);
    }

    loginUser($username, $db);

    header("location: ../index.php");

} 

?>