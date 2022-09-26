<?php
declare(strict_types = 1);

//$_SESSION = array();
session_start();
session_unset();
session_destroy();

header("Location: ../index.php");
exit();
//header('Location: ' . $_SERVER['HTTP_REFERER']);
?>