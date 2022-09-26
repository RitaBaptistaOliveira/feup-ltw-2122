<?php 
declare(strict_types = 1);

require_once('database/connection.db.php');
require_once('database/Menu.class.php');
require_once('database/Product.class.php');

require_once('templates/Menu.tpl.php');
require_once('templates/common.tpl.php');
require_once('utils/session.php');
$session = new Session();

$db = getDatabaseConnection();

$session = new Session;

drawHeader($session);

$menu = Menu::getMenu($db, intval($_GET['id']));
$products = Product::getProducts($db, intval($_GET['id']));

if(isset($_GET['idRestaurant'])){
    drawAddMenu(intval($_GET['idRestaurant']));
}
else{
    drawMenu($db, $session, $menu, $products);
}

drawFooter();
?>