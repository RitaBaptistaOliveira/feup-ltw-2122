<?php
declare(strict_types = 1);

function getUser($id, $db) {
    $stmt = $db->prepare("SELECT * FROM User WHERE idUser = ?");
    $stmt->execute(array($id));

    $user = $stmt->fetchAll();
    return $user;
}

?>