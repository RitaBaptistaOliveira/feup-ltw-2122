<?php 
declare(strict_types = 1);

require_once('database/connection.db.php');
require_once('database/Restaurant.class.php');
include_once('database/user.php');

require_once('templates/review.tpl.php');
require_once('templates/common.tpl.php');
require_once('templates/profile.tpl.php');

require_once('utils/session.php');
require_once('templates/placeOrder.tpl.php');

$session = new Session();
$db = getDatabaseConnection();

drawHeader($session);

if(isset($_GET["idCustomer"]) && isset($_GET["showOrders"])){
    drawCustomerOrders($db, intval($_GET["idCustomer"]));
}
else{
    $reviews = getUnrespondedReviewsByOwner($db, $session);
    drawProfile($session);
    drawUnrespondedReviews($db, $reviews);
    
    if(isset($_GET["success"])){
        echo "<p>Response added successfully!</p>";
    }
}
/*
$id = $session->getID(); 
$products = getFavoriteProducts($db, $id);
$menus = getFavoriteMenus($db, $id);
$restaurants = getFavoriteRestaurants($db, $id);

drawFavoriteProducts($products);
drawFavoriteMenus($menus);
drawFavoriteRestaurants($restaurants);

if($session->getUserType()=="restaurantOwner")

*/
drawFooter();
?>