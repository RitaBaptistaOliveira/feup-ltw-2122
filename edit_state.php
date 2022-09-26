<?php 
declare(strict_types = 1);

session_start();

require_once('database/connection.db.php');

require_once('templates/common.tpl.php');
include_once('templates/placeOrder.tpl.php');

require_once('utils/session.php');
$session = new Session();

$db = getDatabaseConnection();

drawHeader($session);

drawEditStateForm(intval($_GET['idOrder']), $db);

drawFooter();
?>