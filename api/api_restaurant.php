<?php
  declare(strict_types = 1);

  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/Restaurant.class.php');

  $db = getDatabaseConnection();

  $restaurants = Restaurant::searchRestaurants($db, $_GET['search']);

  echo json_encode($restaurants);
?>

