<?php 
declare(strict_types = 1);

require_once('database/connection.db.php');
require_once('database/Menu.class.php');
require_once('database/Restaurant.class.php');
require_once('database/Product.class.php');
require_once('database/Review.class.php');

require_once('templates/review.tpl.php');
require_once('templates/placeOrder.tpl.php');
require_once('templates/Restaurant.tpl.php');
require_once('templates/common.tpl.php');
require_once('utils/session.php');


$session = new Session();
$db = getDatabaseConnection();

drawHeader($session);

if(isset($_GET["idowner"])){
    $restaurants = Restaurant::getRestaurantsByOwner($db, $session->getId());
    drawRestaurantsByOwner($restaurants, $db);
}
else if(isset($_GET["showOrders"])){
    drawRestaurantOwnerOrders($db, $session);
}

else{
    $restaurant = Restaurant::getRestaurant($db, intval($_GET['id']));
    $menus = Menu::getMenus($db, intval($_GET['id']));
    
    drawMenus($db, $session, $restaurant, $menus);

    $products = Product::getRestaurantProducts($db, intval($_GET['id']));

    drawRestaurantProducts($db, $session, $restaurant, $products);

    if(isset($_GET["success"])){
        if($_GET["yes"])
            echo "<p>Added to favorites!</p>";
    }

    drawShoppingCart();

    if(isset($_GET["error"])){
        if($_GET["error"] == "emptyinput"){
            echo "<p>Fill in all fields!</p>" ;    
        }
        else if($_GET["error"] == "notloggedin"){
            echo "<p>You are not logged in!</p>" ;    
        }
        else if($_GET["error"] == "noorder"){
            echo "<p>You have no order to review!</p>" ;    
        }
        else if($_GET["error"] == "none"){ 
            echo "<p>Review done!</p>" ;    
        }
    } 

    $reviews = Review::getRestaurantReviews($db, intval($_GET['id']));
    drawRestaurantReviews($db, intval($_GET['id']), $reviews);
    drawReviewForm(intval($_GET['id']));
}

drawFooter();
?>
