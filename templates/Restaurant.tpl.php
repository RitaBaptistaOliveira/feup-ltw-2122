<?php

declare(strict_types=1);

require_once('database/Restaurant.class.php');
require_once('database/Category.class.php');
require_once('database/Menu.class.php');
require_once('templates/Category.tpl.php');

function drawRestaurant(Restaurant $restaurant, PDO $db)
{ ?>
  <?php $stmt = $db->prepare("SELECT name FROM RestaurantCategory WHERE idCategoryR = ?");

  $stmt->execute(array($restaurant->idCategory));

  $categoryName = $stmt->fetch(); ?>
  <section class = "restaurant">
  <h3><?= htmlspecialchars($restaurant->name) ?></h3>
  <h4><?= htmlspecialchars($restaurant->address) ?></h4>
  <img src = <?="images/restaurants/" . $restaurant->idRestaurant . "." . $restaurant->imageExtension ?> width="300" height="200">
  <p><a href=<?="edit_restaurant.php?idRestaurant=$restaurant->idRestaurant"?>>Edit Restaurant</a></p>
  <p><a href=<?="add_menu.php?idRestaurant=$restaurant->idRestaurant"?>>Add Menu</a></p>
  <p><a href=<?="add_product.php?idRestaurant=$restaurant->idRestaurant"?>>Add Product</a></p>
  </section>
<?php }

function drawRestaurants(array $restaurants)
{ ?>
  <h2>Restaurants</h2>
  <form action="placeOrder.php" method="GET">
    <input name="search" id="searchRestaurants" type="text" placeholder="search">
  </form>
  <section id="restaurants">
    <?php if (empty($restaurants)) { ?>
      <article>
        <img src="images/noRestaurant.png" width="300" height="300">
      </article>
      <?php } 
      else{
         foreach ($restaurants as $restaurant) { ?>
      <article class="restaurant">
        <img src=<?= "images/restaurants/" . $restaurant->idRestaurant . "." . $restaurant->imageExtension?> width="300" height="300">
        <p><a href="restaurant.php?id=<?= $restaurant->idRestaurant ?>"><?= htmlspecialchars($restaurant->name) ?></a></p>
      </article>
    <?php }} ?>
  </section>
<?php } ?>

<?php
function drawMenus(PDO $db, session $session, Restaurant $restaurant, array $menus)
{ ?>
  <h2><?= $restaurant->name ?></h2>
  <?php if ($session->isLoggedIn()) {
    if (!Restaurant::checkFavoriteRestaurant($db, $session, $restaurant->idRestaurant)) { ?>
      <form action="/includes/favorite.inc.php" method="post">
        <button type="submit" class="favoriteButton" name="submit"><i class="fa fa-heart-o" style="font-size:25px;"></i></button>
        <input type="hidden" name="place" value="restaurant">
        <input type="hidden" name="id" value=<?= $restaurant->idRestaurant ?>>
        <input type="hidden" name="idRestaurant" value=<?= $restaurant->idRestaurant ?>>
      </form>
    <?php } else { ?>
      <i class="fa fa-heart" style="font-size:25px;"></i>
  <?php }
  } ?>
  <h2>Menus</h2>
  <section id="menus">
    <?php foreach ($menus as $menu) { ?>
      <article data-id="menu<?=$menu->idMenu ?>" class="menu">
        <h3><a href="menu.php?id=<?= $menu->idMenu ?>"><?= htmlspecialchars($menu->name) ?></a></h3>
        <img src=<?= "images/menu/" . $menu->idRestaurant . "." . $menu->imageExtension?>>
        <input class="quantity" type="number" value="1" min="1">
        <p class="price">Price: <?= $menu->price ?> &euro; </p>
        <button class="buy">Buy</button>
        <?php if ($session->isLoggedIn()) {
          if (!Menu::checkFavoriteMenu($db, $session, $menu->idMenu)) { ?>
            <form action="/includes/favorite.inc.php" method="post">
              <button type="submit" class="favoriteButton" name="submit"><i class="fa fa-heart-o" style="font-size:25px;"></i></button>
              <input type="hidden" name="place" value="menu">
              <input type="hidden" name="id" value=<?= $menu->idMenu ?>>
              <input type="hidden" name="idRestaurant" value=<?= $restaurant->idRestaurant ?>>
            </form>
          <?php } else { ?>
            <i class="fa fa-heart" style="font-size:25px;"></i>
        <?php }
        } ?>
      </article>
    <?php } ?>
  </section>
<?php } ?>

<?php
function drawRestaurantProducts(PDO $db, Session $session, Restaurant $restaurant, array $products)
{ ?>
  <h2>Products</h2>
    <section id="products">
      <?php foreach ($products as $product) { ?>  
        <article data-id="<?= $product->idProduct ?>" class="product">
          <h3><?= htmlspecialchars($product->name) ?></h3>
          <img src=<?= "images/product/" . $product->getProduct() . "." . $product->getImageExtension() ?> width="300" height="200">
          <input class="quantity" type="number" value="1" min="1">
          <p class="price"><?= $product->price ?> &euro; </p>
          <button class="buy">Buy</button>
        <?php if($session->isLoggedIn()) {
          if(!Product::checkFavoriteProduct($db, $session, $product->idProduct)){?>
            <form action="/includes/favorite.inc.php" method="post">
              <button class="favoriteButton" type="submit" name="submit"><i class="fa fa-heart-o" style="font-size:25px;"></i></button>
              <input type="hidden" name="place" value="product">
              <input type="hidden" name="id" value=<?= $product->idProduct ?>>
              <input type="hidden" name="idRestaurant" value=<?= $restaurant->idRestaurant ?>>
            </form>
          <?php } else { ?>
            <i class="fa fa-heart" style="font-size:25px;"></i>
        <?php }
        } ?>
      </article>
    <?php } ?>
  </section>
<?php } ?>

<?php
function drawShoppingCart()
{ ?>
  <h2>Shopping Cart</h2>
  <section id="cart">
    <form action="placeOrder.php" method="POST">
      <table>
        <thead>
          <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
          <tr>
            <th colspan="4">Total:</th>
            <th>0</th>
          </tr>
        </tfoot>
      </table>
      <button type="submit">Place Order</button>
    </form>
  </section>
<?php } ?>

<?php function drawRestaurantsByOwner(array $restaurants, PDO $db)
{ ?>
  <section id="restaurants">
    <?php foreach ($restaurants as $restaurant) {
      drawRestaurant($restaurant, $db);
    } ?>
  </section>
<?php } ?>

<?php
function drawEditRestaurantForm($idRestaurant, $db)
{
  $RestaurantCategories = RestaurantCategory::getRestaurantCategories($db);
  $restaurant = Restaurant::getRestaurant($db, $idRestaurant); ?>
  <form action="../includes/edit_restaurant.inc.php" method="post">
    <p>Name: <input type="text" name="name" value="<?= $restaurant->getName() ?>"></p>
    <p>Address: <input type="text" name="address" value="<?= $restaurant->getAddress() ?>"></p>
    <input type="hidden" name="idRestaurant" value=<?= $idRestaurant ?>>
    <p>Category: <?php drawRestaurantCategories($RestaurantCategories); ?></p>
    <button type="submit" name="submit">Save</button>
    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
  </form>
  <?php
  ?>
<?php } ?>

<?php
if (isset($_GET["error"])) {
  if ($_GET["error"] == "emptyinput") {
    echo "<p>Fill in all fields!</p>";
  }
} ?>