<?php 
declare(strict_types = 1); 
require_once('utils/session.php');
require_once('database/Category.class.php');
require_once('templates/Category.tpl.php');

require_once('database/connection.db.php');
require_once('database/Menu.class.php');
require_once('database/Product.class.php');

require_once('templates/Category.tpl.php');
require_once('templates/common.tpl.php');

function drawAddRestaurant(PDO $db) { 
    $RestaurantCategories = RestaurantCategory::getRestaurantCategories($db);?>
    <h2>Add Restaurant</h2>
    <form action="../includes/add_restaurant.inc.php" method = "post" enctype="multipart/form-data">
        <p><label for = "Restaurant name"> Name: <input type="text" name="name"></label></p>
        <p><label for = "Restaurant address"> Address: <input type="text" name="address"></label></p>
        <p><label for = "Restaurant category"> Category: </label>
        <?php drawRestaurantCategories($RestaurantCategories); ?></p>
        <p><label for="Restaurant image">Photo: </label>
            <input id="image" type="file" name="image" required></p>
        <button type = "submit" name = "submit">Create restaurant</button>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
    </form>
<?php } ?>

<?php function drawAddProduct($idRestaurant, PDO $db){ 
    $ProductCategories = ProductCategory::getProductCategories($db);?>
    <h2>Add Product</h2>
    <form action="../includes/add_product.inc.php" method = "post" enctype="multipart/form-data">
        <p><label for = "Product name"> Name: <input type="text" name="name"></label></p>
        <p><label for = "Product price"> Price: <input type="number" name="price" min = "0"></label></p>
        <p>Category: <?php drawProductCategories($ProductCategories); ?></p>
        <p><label for="Product image"> Photo: </label>
            <input id="image" type="file" name="image" required></p>
        <input type="hidden" name="idRestaurant" value=<?= $idRestaurant?>>
        <button type = "submit" name = "submit">Create Product</button>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
    </form>
<?php } ?>

<?php function drawAddMenu($idRestaurant){ ?>
    <h2>Add Menu</h2>
    <form action="../includes/add_menu.inc.php" method = "post" enctype="multipart/form-data">
        <p><label for = "Menu name"> Name: <input type="text" name="name"></label></p>
        <p><label for = "Menu price"> Price: <input type="number" name="price" min = "0"></label></p>
        <p><label for="Menu image"> Photo: </label>
        <input id="image" type="file" name="image" required></p>
        <input type="hidden" name="idRestaurant" value=<?= $idRestaurant?>>
        <p><button type = "submit" name = "submit">Create Menu</button></p>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
    </form>
<?php } ?>

<?php
if(isset($_GET["error"])){
  if($_GET["error"] == "emptyinput"){
     echo "<p>Fill in all fields!</p>" ;    
  }
  else if($_GET["error"] == "needimage"){ 
   echo "<p>Pick a photo!</p>" ;    
    }
    else if($_GET["error"] == "invalidfile"){ 
    echo "<p>That photo is invalid!</p>" ;    
    }
    else if($_GET["error"] == "none"){
        echo "<p>You created a new Restaurant!</p>";  
        header("location: ../profile.php");  
    }
}
?>