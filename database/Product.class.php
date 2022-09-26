<?php 
    declare(strict_types = 1);

    class Product{
        public int $idProduct;   
        public string $name;        
        public int $idCategory;
        public float $price;
        public string $imageExtension;
        public int $idRestaurant;

        public function __construct(int $idProduct, string $name, int $idCategory, float $price, string $imageExtension, int $idRestaurant)
        { 
            $this->idProduct = $idProduct;
            $this->name = $name;
            $this->idCategory = $idCategory;
            $this->price = $price;
            $this->imageExtension = $imageExtension;
            $this->idRestaurant = $idRestaurant;
        }
        
        function getProduct() : int{
            return $this->idProduct;
        }

        function getName() : string{
            return $this->name; 
        }
        
        function getCategory() : int{
            return $this->idCategory;
        }

        function getPrice() : float{
            return $this->price; 
        }

        function getImageExtension() : string{
            return $this->imageExtension;
        }

        function getRestaurant() : int{
            return $this->idRestaurant;
        }

        static function getProducts(PDO $db, int $idMenu) : array {
            $stmt = $db->prepare('SELECT * FROM (SELECT idProduct FROM MenuProduct WHERE idMenu = ?) as P, Product WHERE P.idProduct = Product.idProduct');
            $stmt->execute(array($idMenu));
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

        static function getRestaurantProducts(PDO $db, $idRestaurant) : array {
            $stmt = $db->prepare('SELECT * FROM Product WHERE idRestaurant = ?');
            $stmt->execute(array($idRestaurant));
            $Products = array();
            while($Product = $stmt->fetch()){
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

        static function checkFavoriteProduct(PDO $db, Session $session, int $idProduct) : bool{
            $idUser = $session->getID();

            $stmt = $db->prepare('SELECT idProduct FROM FavoriteProduct WHERE idCustomer = ? AND idProduct = ?;');
            $stmt->execute(array($idUser, $idProduct));
            $product = $stmt->fetchAll();
            if(count($product)===1)
                return true;
            return false; 
        } 
        
        static function getRestaurantId(PDO $db, int $idProduct) : int {
            $stmt = $db->prepare('SELECT idRestaurant FROM Product WHERE idProduct = ?');
            $stmt->execute(array($idProduct));
            while($id = $stmt->fetch()){
                return $id;
            }
        }
    }
?>
