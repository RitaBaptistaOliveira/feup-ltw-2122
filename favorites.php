<?php 
declare(strict_types = 1);

session_start();

require_once('database/connection.db.php');
require_once('database/user.php');

require_once('templates/profile.tpl.php');
require_once('templates/common.tpl.php');
require_once('utils/session.php');
$session = new Session();

$db = getDatabaseConnection();

drawHeader($session);

$products = getFavoriteProducts($db, intval($_GET['id']));
$menus = getFavoriteMenus($db, intval($_GET['id']));
$restaurants = getFavoriteRestaurants($db, intval($_GET['id']));

drawFavoriteProducts($products);
drawFavoriteMenus($menus);
drawFavoriteRestaurants($restaurants);

drawFooter();
?>
