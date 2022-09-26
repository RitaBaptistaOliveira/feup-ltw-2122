<?php 
declare(strict_types = 1);

require_once('database/connection.db.php');
require_once('database/Product.class.php');

require_once('templates/Product.tpl.php');
require_once('templates/common.tpl.php');
require_once('templates/add.tpl.php');

$db = getDatabaseConnection();

$session = new Session;

drawHeader($session);

if(isset($_GET['idRestaurant'])){
    drawAddProduct(intval($_GET['idRestaurant']), $db);
}
else{
    drawMenu($menu, $products);
}

drawFooter();
?>