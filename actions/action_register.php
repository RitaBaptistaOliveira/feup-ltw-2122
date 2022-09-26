<?php
declare(strict_types = 1);

 function emptyFieldsRegister($username, $screenName, $password, $phonenumber, $address) : bool{
    if(empty($username) || empty($screenName) ||  empty($password) ||  empty($phonenumber) || empty($address)){
        return true; //if any of the fields is empty
    }
    return false; //if all the fields are filled in
 }


 function invalidUsername($username) : bool{
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        return true; //the username has characters that aren't valid
    }
    else{
        return false; //the username is valid
    }
 }


 function takenUsername($username, $db) : bool{
    $stmt = $db->prepare('SELECT * FROM User WHERE username = ?');
    $stmt->execute(array($username));

    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        return true; //the username is already being used
    } else {
        return false; //the username is valid
    }
 }

function invalidPhoneNumber($phonenumber) : bool{

  if(!preg_match("/^(\+?[0-9\s]+|[0-9\s]+-[0-9\s]+)$/", $phonenumber)){
    return true; 
  }
  else{
    return false; 
  }
}

function takenPhoneNumber($phonenumber, $db) : bool{
  $stmt = $db->prepare('SELECT * FROM User WHERE phoneNumber = ?');
  $stmt->execute(array($phonenumber));

  $result = $stmt->fetchAll();

  if (count($result) > 0) {
      return true; //the username is already being used
  } else {
      return false; //the username is valid
  }
}

function samePassword($password, $passwordRepeat) : bool{
  return $password === $passwordRepeat;
}

function createUser($username, $screenName, $password, $phoneNumber, $image, $address, $db){ 

  $stmt = $db -> prepare("INSERT INTO User VALUES (NULL, ?, ?, ?, ?, ?, ?)");

  $hashpassword = password_hash($password, PASSWORD_DEFAULT);

  $stmt -> execute(array($username, $screenName, $hashpassword, $phoneNumber, $image, $address));
    
  return $db->lastInsertId();
}

function createCustomer($id, $db){
  $stmt = $db -> prepare("INSERT INTO Customer VALUES (?)");

  $stmt -> execute(array($id));
}

function createRestaurantOwner($id, $db){
  $stmt = $db -> prepare("INSERT INTO RestaurantOwner VALUES (?)");

  $stmt -> execute(array($id));
}

?>