<?php 
  declare(strict_types = 1); 

  require_once('database/Product.class.php');
  require_once('database/Menu.class.php');
  require_once('templates/Product.tpl.php');

  //draws all restaurants -- por categoria -- por dono -- por rank
  function drawMenu(PDO $db, Session $session, Menu $menu, array $products) {?>
    <section id="products">
      <?php foreach($products as $product) { ?> 
        <p><?=htmlspecialchars($product->name)?></p>
        <img src=<?="images/product/" . $product->idProduct . "." . $product->imageExtension?> width="300" height="200">
        <?php if($session->isLoggedIn()) {
          if(!Product::checkFavoriteProduct($db, $session, $product->idProduct)){?>
            <form action="/includes/favorite.inc.php" method="post">
              <button type="submit" name="submit"><img src="images/heart.png" id="favorite" width="50" height="50"></button>
              <input type="hidden" name="place" value="product">
              <input type="hidden" name="id" value=<?= $product->idProduct ?>>
              <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            </form>
          <?php } 
          else { ?>
            <img src="images/favoriteHeart.png" width="50" height="50">
          <?php } 
         } 
      } ?>
    </section>
  <?php } ?>
