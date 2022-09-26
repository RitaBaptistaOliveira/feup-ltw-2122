<?php

declare(strict_types=1);

session_start();

require_once('database/connection.db.php');
require_once('database/Restaurant.class.php');
require_once('database/Category.class.php');

require_once('templates/common.tpl.php');
require_once('templates/Restaurant.tpl.php');
require_once('templates/Category.tpl.php');
require_once('templates/placeOrder.tpl.php');
require_once('utils/session.php');
$session = new Session();

$db = getDatabaseConnection();

if (isset($_GET["search"])) {
    $restaurants = Restaurant::searchRestaurants($db, $_GET["search"]);
    if ($_GET["search"] == "")
        $restaurants = Restaurant::getRestaurants($db);
} else if (isset($_GET["filter"])) {
    $restaurants = Restaurant::getRestaurantsByCategory($db, intval($_GET["filter"]));
} else {
    $restaurants = Restaurant::getRestaurants($db);
}

$categories = RestaurantCategory::getRestaurantCategories($db);


drawHeader($session);
?>

<section id="placeOrderPage">
    <?php
    drawSideBar($categories);

    drawRestaurants($restaurants);

    ?>
</section>
<?php
drawFooter();
?>