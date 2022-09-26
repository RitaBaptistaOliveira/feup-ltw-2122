<?php

declare(strict_types=1);
require_once('templates/common.tpl.php');
require_once('templates/add.tpl.php');
require_once('database/connection.db.php');
require_once('utils/session.php');

$session = new Session;
$db = getDatabaseConnection();

drawHeader($session);

drawAddRestaurant($db);

drawFooter();

?>