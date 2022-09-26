<?php
declare(strict_types = 1);

function emptyFieldsMenu($name, $price)  : bool{
  if(empty($name) || empty($price)){
      return true; //if any of the fields is empty
  }
  return false; //if all the fields are filled in
}

function createMenu($name, $price, $imageExtension, $idRestaurant, PDO $db){ 

  $stmt = $db -> prepare("INSERT INTO Menu VALUES (NULL, ?, ?, ?, ?)");

  $stmt -> execute(array($name, intval($price), $imageExtension, $idRestaurant));
    
  return $db->lastInsertId();
}

?>