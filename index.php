<?php 
declare(strict_types = 1);
require_once('utils/session.php');

//session_start();

$session = new Session;

require_once('database/connection.db.php');
require_once('database/Category.class.php');

require_once('templates/Category.tpl.php');
require_once('templates/common.tpl.php');
require_once('templates/Restaurant.tpl.php');

//$db = Database::instance()->db();
$db = getDatabaseConnection();

drawHeader($session);

drawMainPage($session);

drawFooter();
?>