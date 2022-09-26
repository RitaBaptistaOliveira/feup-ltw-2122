<?php
require_once("../actions/action_register.php");
include_once("utils/session.php");

function updateDatabase(Session $session, $id, $newUsername, $newScreenName, $newPassword, $newPhoneNumber, $newAddress, PDO $db){

    if(!invalidUsername($newUsername) && !invalidPhoneNumber($newPhoneNumber)){

        $session->setUsername($newUsername);
        $session->setPhoneNumber($newPhoneNumber);
        $session->setAddress($newAddress);
    
        $hashpassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $db->prepare('UPDATE User 
        SET username = ?, screenName = ?, password = ?, phoneNumber = ?, address = ? WHERE idUser = ? ');
        $stmt->execute(array($newUsername, $newScreenName, $hashpassword, $newPhoneNumber, $newAddress, $id));
    }
}
?>