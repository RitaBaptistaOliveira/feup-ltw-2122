<?php
  declare(strict_types = 1);

  session_start();

  require_once('database/connection.php');

  require_once('database/category.class.php');

  require_once('templates/category.tpl.php');

  $db = getDatabaseConnection();

  //$db = Database::instance()->db();

  $RestaurantCategories = RestaurantCategory::getRestaurantCategories($db);

  drawRestaurantCategories($RestaurantCategories);
?>