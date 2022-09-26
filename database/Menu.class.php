<?php 
    declare(strict_types = 1);

    class Menu{
        public int $idMenu;   
        public string $name;     
        public float $price;     
        public string $imageExtension;     
        public int $idRestaurant;

        public function __construct(int $idMenu, string $name, float $price, string $imageExtension, int $idRestaurant)
        { 
            $this->idMenu = $idMenu;
            $this->name = $name;
            $this->price = $price;
            $this->imageExtension = $imageExtension;
            $this->idRestaurant = $idRestaurant;
        }

        function getIdMenu() : int{
            return $this->idMenu;
        }

        function getName() : string{
            return $this->name; 
        }

        function getPrice() : float{
            return $this->price; 
        }

        function getImageExtension() : string{
            return $this->image;
        }

        function getRestaurant() : int{
            return $this->idRestaurant;
        }

        static function getMenu(PDO $db, int $id) : Menu{
            $stmt = $db->prepare('SELECT * FROM Menu WHERE idMenu = ?');
            $stmt->execute(array($id));
            $menu = $stmt->fetch();
      
            return new Menu(
                intval($menu['idMenu']),
                $menu['name'], 
                floatval($menu['price']),
                $menu['imageExtension'],
                intval($menu['idRestaurant'])
            );  
        }

        static function getMenus(PDO $db, int $idRestaurant) : array {
            $stmt = $db->prepare('SELECT * FROM Menu WHERE idRestaurant = ?');
            $stmt->execute(array($idRestaurant));
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

        static function checkFavoriteMenu(PDO $db, Session $session, int $idMenu) : bool{
            $idUser = $session->getID();

            $stmt = $db->prepare('SELECT idMenu FROM FavoriteMenu WHERE idCustomer = ? AND idMenu = ?;');
            $stmt->execute(array($idUser, $idMenu));
            $menu = $stmt->fetchAll();
            if(count($menu)===1)
                return true;
            return false;   
        }
    }
?>