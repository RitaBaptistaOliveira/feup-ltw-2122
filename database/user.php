<?php
  declare(strict_types = 1);

  require_once("database/connection.db.php");
  require_once("utils/session.php");
  require_once("database/Review.class.php");

/*
  function createUser($username, $screename, $password, $phoneNumber, $imageExtens, $address, $db){ 
      $stmt = $db -> prepare("INSERT INTO User (username, screenName, password, phoneNumber, imageExtensio, address) VALUES (?, ?, ?, ?, ?);");
  
      $hashpassword = password_hash($password, PASSWORD_DEFAULT);
  
      $stmt -> execute(array($username, $screename, $hashpassword, $phoneNumber, $imageExtensio, $address));
      return $db->lastInsertId();
  }
*/
  function getFavoriteProducts(PDO $db, int $id) : array{
    $stmt = $db->prepare('SELECT * FROM (SELECT idProduct FROM FavoriteProduct WHERE idCustomer = ?) as P, Product WHERE P.idProduct = Product.idProduct');
    $stmt->execute(array($id));
    $Products = array();
    while ($Product = $stmt->fetch()){
      $Products[] = new Product(
        intval($Product['idProduct']),
        $Product['name'],
        intval($Product['idCategory']), 
        floatval($Product['price']),
        $Product['imageExtension'],
        intval($Product['idRestaurant'])
      );
    }
    return $Products;
}

  function getFavoriteMenus(PDO $db, int $id){
    $stmt = $db->prepare('SELECT * FROM (SELECT idMenu FROM FavoriteMenu WHERE idCustomer = ?) as M, Menu WHERE M.idMenu = Menu.idMenu');

    $stmt->execute(array($id));
    $Menus = array();
    while ($Menu = $stmt->fetch()){
      $Menus[] = new Menu(
        intval($Menu['idMenu']),
        $Menu['name'], 
        floatval($Menu['price']),
        $Menu['imageExtension'],
        intval($Menu['idRestaurant'])
      );
    }

    return $Menus;
  }

  function getFavoriteRestaurants(PDO $db, int $id){
    $stmt = $db->prepare('SELECT * FROM (SELECT idRestaurant FROM FavoriteRestaurant WHERE idCustomer = ?) as R, Restaurant WHERE R.idRestaurant = Restaurant.idRestaurant');

    $stmt->execute(array($id));
    $Restaurants = array();
    while ($Restaurant = $stmt->fetch()){
      $Restaurants[] = new Restaurant(
        intval($Restaurant['idRestaurant']),
        $Restaurant['name'],
        $Restaurant['address'],
        intval($Restaurant['idCategory']),
        $Restaurant['imageExtension'] == NULL? "" : $Restaurant['imageExtension'],
        intval($Restaurant['idOwner'])
      );
    }

    return $Restaurants;
  }

  function getIdName(PDO $db, int $id) : string{
    $stmt = $db->prepare('SELECT username FROM User WHERE idUser = ?;');
    $stmt->execute(array($id));
    while($name = $stmt->fetch()){
      foreach($name as $n){
        return $n;
      }
    }
  }

  function getRestaurantOwner(PDO $db, int $idRestaurant) : string {
    $stmt = $db->prepare('SELECT idOwner FROM Restaurant WHERE idRestaurant = ?;');
    $stmt->execute(array($idRestaurant));
    
    $idOwner = $stmt->fetch();
    $id = $idOwner['idOwner'];
    
    $stmt = $db->prepare('SELECT username FROM User WHERE idUser = ?;');
    $stmt->execute(array($id));
    
    $owner = $stmt->fetch();
    return $owner['username'];
    
  }

  function getUnrespondedReviewsByOwner(PDO $db, Session $session) : array {
    $idOwner = $session->getID();

    $stmt = $db->prepare('SELECT Review.* FROM (SELECT idRestaurant FROM Restaurant WHERE idOwner = ?) as R, Review WHERE R.idRestaurant = Review.idRestaurant AND response IS NULL;');
    $stmt->execute(array($idOwner));
    $reviews = array();

    while($review = $stmt->fetch()){
      $reviews[] = new Review(
        intval($review['idCustomer']),
        intval($review['idRestaurant']),
        $review['date'],
        $review['description'],
        intval($review['rating']),
        $review['response'] == NULL? "" : $review['response']
      );
    }
    
    return $reviews;
  }

?>