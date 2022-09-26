<?php
declare(strict_types = 1);

function emptyFieldsProduct($name, $price, $productCategory)  : bool{
  if(empty($name) || empty($price) || empty($productCategory)){
      return true; //if any of the fields is empty
  }
  return false; //if all the fields are filled in
}

function createProduct($name, $price, $idCategory, $imageExtension, $idRestaurant, PDO $db){ 

  $stmt = $db -> prepare("INSERT INTO Product VALUES (NULL, ?, ?, ?, ?, ?)");

  $stmt -> execute(array($name, $idCategory, intval($price), $imageExtension, $idRestaurant));
    
  return $db->lastInsertId();
}

?>