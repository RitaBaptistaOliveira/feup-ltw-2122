<?php
  declare(strict_types = 1);

  class  Restaurant{
    public int $idRestaurant;
    public string $name;
    public string $address;
    public int $idCategory;
    public string $imageExtension;
    public int $idOwner;

    public function __construct(int $idRestaurant, string $name, string $address, int $idCategory, string $imageExtension, int $idOwner)
    { 
      $this->idRestaurant = $idRestaurant;
      $this->name = $name;
      $this->address = $address;
      $this->idCategory = $idCategory;
      $this->imageExtension = $imageExtension;
      $this->idOwner = $idOwner;
    }
    
    function getId(){
      return $this->idRestaurant;
    }

    function getName(){
      return $this->name;
    }

    function getAddress(){
      return $this->address;
    }

    static function getRestaurant(PDO $db, int $id) : Restaurant{
      $stmt = $db->prepare('SELECT * FROM Restaurant WHERE idRestaurant = ?');
      $stmt->execute(array($id));
      $Restaurant = $stmt->fetch();

      return new Restaurant(
        intval($Restaurant['idRestaurant']),
        $Restaurant['name'],
        $Restaurant['address'],
        intval($Restaurant['idCategory']),
        $Restaurant['imageExtension'] == NULL? "" : $Restaurant['imageExtension'],
        intval($Restaurant['idOwner'])
      );  
    }
    
    static function getRestaurants(PDO $db) : array {
      $stmt = $db->prepare('SELECT * FROM Restaurant');
      $stmt->execute();
      $Restaurants = array();
      while ($Restaurant = $stmt->fetch()) {
        $Restaurants[] = new Restaurant(
          intval($Restaurant['idRestaurant']),
          $Restaurant['name'],
          $Restaurant['address'],
          intval($Restaurant['idCategory']),
          $Restaurant['imageExtension'],
          intval($Restaurant['idOwner'])
        );
      }
  
      return $Restaurants;
    }

    static function getRestaurantsByCategory(PDO $db, int $id) : array {
        $stmt = $db->prepare('SELECT * FROM Restaurant WHERE Restaurant.idCategory = ?');
        $stmt->execute(array($id));
        $Restaurants = array();
        while ($Restaurant = $stmt->fetch()) {
          $Restaurants[] = new Restaurant(
            intval($Restaurant['idRestaurant']),
            $Restaurant['name'],
            $Restaurant['address'],
            intval($Restaurant['idCategory']),
            $Restaurant['imageExtension'],
            intval($Restaurant['idOwner'])
          );
        }
    
        return $Restaurants;
      }
      
      static function getRestaurantsByDish(PDO $db, string $name) : array {
        $stmt = $db->prepare('SELECT Restaurant.idRestaurant,
        Restaurant.name, Restaurant.address, Restaurant.idCategory,
        Restaurant.imageExtension
  , Restaurant.idOwner
        FROM Restaurant, Product 
        WHERE Restaurant.idRestaurant = Product.idRestaurant 
        AND Product.name = ?');
        $stmt->execute(array($name));
        $Restaurants = array();
        while ($Restaurant = $stmt->fetch()) {
          $Restaurants[] = new Restaurant(
            intval($Restaurant['idRestaurant']),
            $Restaurant['name'],
            $Restaurant['address'],
            intval($Restaurant['idCategory']),
            $Restaurant['imageExtension'],
            intval($Restaurant['idOwner'])
          );
        }
    
        return $Restaurants;
      }

      static function getRestaurantsByOwner(PDO $db, int $id) : array {
        $stmt = $db->prepare('SELECT *
        FROM Restaurant 
        WHERE idOwner = ?');
        $stmt->execute(array($id));
        $Restaurants = array();
        while ($restaurant = $stmt->fetch()) {
          $Restaurants[] = new Restaurant(
            intval($restaurant['idRestaurant']),
            $restaurant['name'],
            $restaurant['address'],
            intval($restaurant['idCategory']),
            $restaurant['imageExtension'],
            $id
          );
        }
    
        return $Restaurants;
      }

      static function searchRestaurants(PDO $db, string $search) : array {
        $search = $search ."%";
        $stmt = $db->prepare('SELECT * FROM Restaurant WHERE name LIKE ?');
        $stmt->execute(array($search));
    
        $restaurants = array();
        while ($restaurant = $stmt->fetch()) {
            $restaurants[] = new Restaurant(
              intval($restaurant['idRestaurant']),
              $restaurant['name'],
              $restaurant['address'],
              intval($restaurant['idCategory']),
              $restaurant['imageExtension'],
              intval($restaurant['idOwner'])
            );
        }
    
        return $restaurants;
      }

      static function checkFavoriteRestaurant(PDO $db, Session $session, int $idRestaurant) : bool{
        $idUser = $session->getID();

        $stmt = $db->prepare('SELECT idRestaurant FROM FavoriteRestaurant WHERE idCustomer = ? AND idRestaurant = ?;');
        $stmt->execute(array($idUser, $idRestaurant));
        $restaurant = $stmt->fetchAll();
        if(count($restaurant)===1)
          return true;
        return false; 
      }

      static function getNamebyId(PDO $db, int $idRestaurant){
        $stmt = $db->prepare('SELECT Restaurant.name FROM Restaurant WHERE idRestaurant = ?;');
        $stmt->execute(array($idRestaurant));

        while($name = $stmt->fetch()){
          foreach($name as $n)
            return $n;
        }
      }

/*
      static function getRestaurantsByRate(PDO $db, int $value) : array {
        $stmt = $db->prepare('SELECT *
        FROM Restaurant 
        WHERE Restaurant.rating >= ?');
        $stmt->execute(array($value));
        $Restaurants = array();
        while ($Restaurant = $stmt->fetch()) {
          $Restaurants[] = new Restaurant(
            intval($Restaurant['idRestaurant']),
            $Restaurant['name'],
            $Restaurant['address'],
            intval($Restaurant['idCategory']),
            $Restaurant['imageExtension
      '],
            intval($Restaurant['idOwner'])
          );
        }
    
        return $Restaurants;
      }
*/
  }
