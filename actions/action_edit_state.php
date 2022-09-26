<?php
require_once("../actions/action_register.php");
include_once("utils/session.php");

function updateDatabase($idOrder, $state, PDO $db){

    $stmt = $db->prepare('UPDATE Purchase 
    SET state = ? WHERE idOrder = ? ');
    $stmt->execute(array($state, $idOrder));

}
?>