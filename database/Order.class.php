<?php
  declare(strict_types = 1);

  class Purchase{
    public int $idOrder;   
    public string $state;     
    public float $total;     
    public string $date;   
    public int $idCustomer;  
    public int $idRestaurant;

    public function __construct(int $idOrder, string $state, float $total, string $date, int $idRestaurant, int $idCustomer)
    { 
        $this->idOrder = $idOrder;
        $this->state = $state;
        $this->total = $total;
        $this->date = $date;
        $this->idRestaurant = $idRestaurant;
        $this->idCustomer = $idCustomer;
    }    

    function createOrder(PDO $db, int $idCustomer, int $idRestaurant){ 
        $stmt = $db -> prepare("INSERT INTO Purchase VALUES (?, ?, ?, ?, ?);");
        
        $stmt -> execute(array("cart", 0, date("Y/m/d"), $idCustomer, $idRestaurant));
    }

    function getId(){
      return $this->idOrder;
    }

    function getState(){
      return $this->state;
    }

    function getOrderTotal(){
      return $this->total;
    }

    function getDate(){
      return $this->date;
    }

  static function getTotal(PDO $db, int $idOrder) : float{
      $stmt = $db -> prepare("SELECT total FROM Purchase WHERE idOrder = ?;");

      $stmt->execute(array($idOrder));
      $total = $stmt->fetch();

      return $total;
  }

  static function getOrder(PDO $db, $idOrder) : Purchase{
    $stmt = $db->prepare('SELECT * FROM Purchase WHERE idOrder = ?');
    $stmt->execute( array($idOrder));
    $order = $stmt->fetch();
    return new Purchase(
      intval($order['idOrder']),
      $order['state'],
      floatval($order['total']),
      $order['date'],
      intval($order['idRestaurant']),
      intval($order['idCustomer'])
    );
  }  

  static function getOrders(PDO $db, $idRestaurant) : array{
    $stmt = $db->prepare('SELECT * FROM Purchase WHERE idRestaurant = ?');
    $stmt->execute( array($idRestaurant));
    $Orders = array();
    while ($order = $stmt->fetch()) {
      $Orders[] = new Purchase(
        intval($order['idOrder']),
        $order['state'],
        floatval($order['total']),
        $order['date'],
        intval($order['idRestaurant']),
        intval($order['idCustomer'])
      );
    }
    return $Orders;
  }

  static function getCustomerOrders(PDO $db, $idCustomer) : array{
    $stmt = $db->prepare('SELECT * FROM Purchase WHERE idCustomer = ?');
    $stmt->execute( array($idCustomer));
    $Orders = array();
    while ($order = $stmt->fetch()) {
      $Orders[] = new Purchase(
        intval($order['idOrder']),
        $order['state'],
        floatval($order['total']),
        $order['date'],
        intval($order['idRestaurant']),
        intval($order['idCustomer'])
      );
    }
    return $Orders;
  }

    static function getCartOrder(PDO $db, int $idCustomer){
        $stmt = $db -> prepare("SELECT * FROM Purchase WHERE idCostumer = ? AND state = cart;");

        $stmt->execute(array($idCustomer));
        $order = $stmt->fetch();
        
        return new Purchase(
            intval($order['idOrder']),
            $order['state'],
            floatval($order['total']),
            $order['date'],
            intval($order['idRestaurant']),
            intval($order['idCustomer'])
        );
    }

    function insertProduct(PDO $db, int $idOrder, int $idProduct, int $quantity, int $price){
        $stmt = $db -> prepare("INSERT INTO OrderProduct VALUES (?, ?, ?);");
        $stmt -> execute(array($idOrder, $idProduct, $quantity));

        $stmt2 = $db -> prepare("SELECT total FROM Purchase WHERE idOrder = ?;");
        $stmt2->execute(array($idOrder));
        $total = $stmt->fetch();

        $total = $total + ($quantity * $price);

        $stmt2 = $db->prepare('UPDATE User SET state = received, total = ?');
        $stmt->execute(array($total));
    }

    function insertMenu(PDO $db, int $idOrder, int $idMenu, int $quantity, int $price){
        $stmt = $db -> prepare("INSERT INTO OrderMenu VALUES (?, ?, ?);");
        $stmt -> execute(array($idOrder, $idMenu, $quantity));

        $stmt2 = $db -> prepare("SELECT total FROM Purchase WHERE idOrder = ?;");
        $stmt2->execute(array($idOrder));
        $total = $stmt->fetch();

        $total = $total + ($quantity * $price);

        $stmt2 = $db->prepare('UPDATE User SET state = received, total = ?');
        $stmt->execute(array($total));
    }

}
?>