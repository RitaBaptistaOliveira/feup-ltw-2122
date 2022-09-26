<?php
declare(strict_types = 1);

/*
require_once(__DIR__ . '/utils/session.php');
$session = new Session();
*/

include('../actions/action_login.php');
//include('functions.inc.php');

include_once('../database/connection.db.php');

if(isset($_POST["submit"])){
    if ($_SESSION['csrf'] !== $_POST['csrf']) {
        header("Location: ../index.php");
    }
    $username = $_POST["username"];
    $password = $_POST["password"];
    //$db = Database::instance()->db();
    
    //require_once('database/connection.db.php');
    $db = getDatabaseConnection();

    //emptyfields
    if (emptyFieldsLogin($username, $password) !== false){
        header("Location: ../login.php?error=emptyinput");
        exit();
    }

    //check if the username is valid
    if (invalidUsernameLogin($username) !== false){
        header("Location: ../login.php?error=invalidusername");
        exit();
    }

    //check if the username exists
    if (checkUsername($username, $db) === false){
        header("Location: ../login.php?error=nonexistentusername");
        exit();
    }

    //check if the username and password match
    if (checkUserPassword($username, $password, $db) === false){
        header("Location: ../login.php?error=wrongpassword");
        exit();
    }

    loginUser($username, $db);
} 

?>