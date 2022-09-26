<?php 
declare(strict_types = 1); 

require_once('database/Category.class.php');

function drawRestaurantCategories(array $categories) { ?>
  <select id="RestaurantCategories" name ="restaurantCategory">
    <?php foreach($categories as $category) { ?> 
      <option value=<?= $category->idCategoryR?>><?=$category->name?></option>
    <?php } ?>
  </select>
<?php } ?>

<?php function drawProductCategories(array $categories) { ?>
  <select id="ProductCategories" name ="productCategory">
    <?php foreach($categories as $category) { ?> 
      <option value=<?=$category->idCategoryP?>><?=$category->name?></option>
    <?php } ?>
  </select>
<?php } ?>
