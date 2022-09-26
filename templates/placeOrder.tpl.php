<?php

declare(strict_types=1);

require_once('database/Category.class.php');
require_once('database/Restaurant.class.php');
include_once('database/Order.class.php');

require_once('database/connection.db.php');
require_once('utils/session.php');

$session = new Session;
$db = getDatabaseConnection();

function drawSideBar(array $categories)
{ ?>
    <section id="sideBar">

        <form action="placeOrder.php" method="GET">
            <h3>Filter</h3>
            <section id="filters">
                <ul>
                    <?php foreach ($categories as $category) { ?>
                        <li>
                            <input type="radio" class="filter" name="filter" value=<?= $category->idCategoryR ?>>
                            <label for="filter <?= $category->idCategoryR ?>"><?= $category->name ?></label>
                        </li>
                    <?php } ?>
                </ul>
            </section>
            <button type="submit">Search</button>
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        </form>
    </section>

<?php } 

function drawOrder(Purchase $order) { ?>
    <h4>Order Number: <?php echo $order->getId()?></h4>
    <h5>State: <?php echo htmlspecialchars($order->getState())?></h5>
    <h5>Total: <?php echo $order->getOrderTotal()?></h5>
    <h5>Date: <?php echo htmlspecialchars($order->getDate())?></h5>
<?php }

function drawRestaurantOrders(PDO $db, $idRestaurant){
    $orders = Purchase::getOrders($db, $idRestaurant);
    foreach ($orders as $order) { 
        drawOrder($order);?>
        <a href=<?="edit_state.php?idOrder=" . $order->getId()?> class="fa fa-pencil">Edit state</a>
    <?php } 
}

function drawRestaurantOwnerOrders(PDO $db, $session) { 
    $restaurants = Restaurant:: getRestaurantsByOwner($db, $session->getId());
    foreach($restaurants as $restaurant){ ?>
        <article class="checkOrder">
        <?php drawRestaurantOrders($db, $restaurant->getId()); ?>
        </article>
    <?php }
}

function drawCustomerOrders(PDO $db, $idCustomer) {
    $orders = Purchase::getCustomerOrders($db, $idCustomer);
    foreach ($orders as $order) { 
        drawOrder($order);?>
    <?php } 
}

function drawEditStateForm($idOrder, $db) {
    $order = Purchase::getOrder($db, $idOrder);?>
    <form action="../includes/edit_state.inc.php" method="post">
        <h4>Order Number: <?php echo $order->getId()?></h4>
        <h5>Total: <?php echo $order->getOrderTotal()?></h5>
        <h5>Date: <?php echo $order->getDate()?></h5>
        <select id="OrderState" name ="orderState">
            <option value="cart">In Cart</option>
            <option value="recieved">Recieved</option>
            <option value="preparing">Preparing</option>
            <option value="ready">Ready</option>
            <option value="delivered">Delivered</option>
        </select>
        <input type = "hidden" name = "idOrder" value=<?=$order->getId()?>>
        <button type="submit" name="submit">Edit State</button>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
   </form>   
<?php } ?>