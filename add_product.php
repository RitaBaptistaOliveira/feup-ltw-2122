<?php

declare(strict_types = 1);

require_once('templates/common.tpl.php');
include_once('../utils/session.php');
require_once('templates/add.tpl.php');
require_once('database/connection.db.php');

$db = getDatabaseConnection();

$session = new Session;

drawHeader($session);

if($_GET["idRestaurant"]){
    drawAddProduct(intval($_GET['idRestaurant']), $db);
}

if($_GET["error"]){
}

drawFooter();
?>