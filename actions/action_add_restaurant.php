<?php
declare(strict_types = 1);

function emptyFieldsRestaurant($name, $address, $restaurantCategory) : bool{
  if(empty($name) || empty($address) || empty($restaurantCategory)){
      return true; //if any of the fields is empty
  }
  return false; //if all the fields are filled in
}

function createRestaurant($name, $address, $imageExtension, $restaurantCategory, PDO $db, Session $session){ 

  $stmt = $db -> prepare("INSERT INTO Restaurant VALUES (NULL, ?, ?, ?, ?, ?)");

  $stmt -> execute(array($name, $address, $restaurantCategory, $imageExtension, $session->getId()));
    
  return $db->lastInsertId();
}

?>