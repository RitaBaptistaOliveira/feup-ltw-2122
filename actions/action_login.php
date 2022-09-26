<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');

function emptyFieldsLogin($username, $password) : bool{
    if(empty($username) ||  empty($password)){
        return true; //if any of the fields is empty
    }
    else{
        return false; //if all the fields are filled in
    }
}

function invalidUsernameLogin($username) : bool{
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        return true; //the username has characters that aren't valid
    }
    else{
        return false; //the username is valid
    }
 }

function checkUsername($username, $db) : bool{
    $stmt = $db->prepare('SELECT * FROM User WHERE username = :user_name');
    $stmt->execute(array(':user_name'=>$username));

    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        return true; //the username is already being used
    } else {
        return false; //the username is valid
    }
}

function getUser($username, $db) {
    $stmt = $db->prepare("SELECT * FROM User WHERE username = ?");
    $stmt->execute(array($username));

    $user = $stmt->fetch();
    return $user;
}

function checkUserPassword($username, $password, $db) : bool{
    $user = getUser($username, $db);

    //$hashpassword = password_hash($password, PASSWORD_DEFAULT);
    //$hashpassword = sha1($password);
    if(password_verify($password, $user['password'])){
    //if($hashpassword === $user['password']){
        return true;
    }
    else{
        return false;
    }
}

function checkUserType($id, $db)
{
    $stmt = $db->prepare('SELECT * FROM Customer WHERE idCustomer = ?');
    $stmt->execute(array($id));

    $customer = $stmt->fetchAll();

    //var_dump($customer);

    if (count($customer) !== 0) {
        return "customer"; //the user is a customer
    } else {
        return "restaurantOwner"; //the user is a restaurant owner
    }
}

function loginUser($username, $db){

    $user = getUSer($username, $db);

    echo "id = " . $user["idUser"];
    echo "name = " . $user["screenName"];
    echo "address = " . $user["address"];
    echo "phone = " . intval($user["phoneNumber"]);
    echo "username = " . $user["username"];
    echo "type = " . checkUserType($user['idUser'], $db);

    $session = new Session();

    $session->setCart();
    $session->setId(intval($user["idUser"]));
    $session->setScreenName($user["screenName"]);
    $session->setAddress($user["address"]);
    $session->setPhoneNumber(intval($user["phoneNumber"]));
    $session->setUsername($user["username"]);
    $session->setPhotoExt($user['imageExtension']);
    $session->setUserType(checkUserType($user['idUser'], $db));

    header("location: ../index.php");
    exit();
}
?>