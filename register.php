<?php
declare(strict_types = 1);

session_start();

require_once('templates/common.tpl.php');
require_once('templates/register.tpl.php');

include_once('includes/register.inc.php');
require_once('utils/session.php');

$session = new Session();

//if (!$session->isLoggedIn()) die(header('Location: /'));

drawHeader($session);

drawRegisterForm();

drawFooter();

?>