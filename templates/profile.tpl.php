<?php

declare(strict_types=1);
require_once('includes/functions.inc.php');
require_once('utils/session.php');

require_once('database/user.php');
require_once('database/Restaurant.class.php');
require_once('database/Product.class.php');
require_once('database/Menu.class.php');

function drawProfile(Session $session)
{ ?>

  <section id="profile">
    <img src=<?= "images/users/" . $session->getId() . "." . $session->getPhotoExt() ?> width="200" height="200">

    <section id="infoProfile">
      <h2><?= htmlspecialchars($session->getScreenName()) ?></h2>
      <h4>Username: <?= htmlspecialchars($session->getUsername()) ?></h4>
      <h4>Phone number: <?= $session->getPhoneNumber() ?></h4>
      <h4>Address: <?= htmlspecialchars($session->getAddress()) ?></h4>
    </section>
  </section>
  <?php if ($session->getUserType() == "restaurantOwner") { ?>
    <p><a href="add_restaurant.php">Create Restaurant</a></p>
    <p><a href=<?= "restaurant.php?idowner=" . $session->getId() ?>>See Your Restaurants</a></p>
    <p><a href="restaurant.php?showOrders">Check Your Orders</a></p>
    <a href=" edit_profile.php" class="fa fa-pencil">Edit profile</a>
  <?php } else { ?>
    <p><a href="profile.php?showOrders&&idCustomer=<?= $session->getId() ?>">Check Your Orders</a></p>
    <p><a href=" edit_profile.php" class="fa fa-pencil">Edit profile</a></p>
  <?php } ?>

<?php } ?>

<?php
function drawEditProfileForm(Session $session)
{ ?>
  <form action="../includes/edit_profile.inc.php" method="post">
    Username: <input type="text" name="username" value="<?= htmlspecialchars($session->getUsername()) ?>">
    <p>Name: <input type="text" name="screenName" value="<?= htmlspecialchars($session->getScreenName()) ?>"></p>
    <p>Password: <input type="password" name="password" placeholder="New password"></p>
    <p>Phone number: <input type="text" name="phoneNumber" value="<?= $session->getPhoneNumber() ?>"></p>
    <p>Address: <input type="text" name="address" value="<?= htmlspecialchars($session->getAddress()) ?>"></p>
    <button type="submit" name="submit">Save</button>
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
  </form>
  <?php
  ?>
<?php } ?>

<?php
function drawFavoriteProducts(array $products)
{ ?>
  <h2>Favorites Products</h2>
  <section id="products">
    <?php foreach ($products as $product) { ?>
      <p><?= htmlspecialchars($product->name) ?></p>
      <img src="images/product/<?= $product->idProduct ?>.<?= $product->imageExtension ?>" width="300" height="200">
    <?php } ?>
  </section>
<?php } ?>

<?php
function drawFavoriteMenus(array $menus)
{ ?>
  <h2>Favorite Menus</h2>
  <section id="menus">
    <?php foreach ($menus as $menu) { ?>
      <article>
        <img src="images/menu/<?= $menu->idMenu ?>.<?= $menu->imageExtension ?>">
        <a href="menu.php?id=<?= $menu->idMenu ?>"><?= $menu->name ?></a>
      </article>
    <?php } ?>
  </section>
<?php } ?>

<?php 
  function drawFavoriteRestaurants(array $restaurants) { ?>
    <h2>Favorite Restaurants</h2>
    <section id="restaurants">
      <?php foreach ($restaurants as $restaurant) { ?>  
        <article>
          <img src="images/restaurants/<?=$restaurant->idRestaurant?>.<?=$restaurant->imageExtension?>">
          <a href="restaurant.php?id=<?=$restaurant->idRestaurant?>"><?=$restaurant->name?></a>
        </article>
      <?php } ?>
    </section>
<?php } ?>

