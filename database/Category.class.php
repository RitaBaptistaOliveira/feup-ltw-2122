<?php
  declare(strict_types = 1);

  class  RestaurantCategory{
    public int $idCategoryR;
    public string $name;

    public function __construct(int $idCategoryR, string $name)
    { 
      $this->idCategoryR = $idCategoryR;
      $this->name = $name;
    }

    function getId(){
      if($this->idCategoryR === NULL){
        die();
      }
      else{
        return $this->idCategoryR;
      }
    }

    static function getRestaurantCategories(PDO $db) : array {
      $stmt = $db->prepare('SELECT * FROM RestaurantCategory');
      $stmt->execute();
  
      $Rcategories = array();
      while ($RestaurantCategory = $stmt->fetch()) {
        $Rcategories[] = new RestaurantCategory(
          intval($RestaurantCategory['idCategoryR']),
          $RestaurantCategory['name']
        );
      }
  
      return $Rcategories;
    }
  }

class  ProductCategory{
  public int $idCategoryP;
  public string $name;

  public function __construct(int $idCategoryP, string $name)
  { 
    $this->idCategoryP = $idCategoryP;
    $this->name = $name;
  }

  static function getProductCategories(PDO $db) : array {
    $stmt = $db->prepare('SELECT idCategoryP, name FROM ProductCategory');
    $stmt->execute();

    $Pcategories = array();
    while ($ProductCategory = $stmt->fetch()) {
      $Pcategories[] = new ProductCategory(
        intval($ProductCategory['idCategoryP']),
        $ProductCategory['name']
      );
    }

    return $Pcategories;
  }
}

?>