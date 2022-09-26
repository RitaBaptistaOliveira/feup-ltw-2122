<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');

function updateCart($id, $price, $quantity, $db)
{
    if(checkLogin()){
        session_start();
        $cart = $_SESSION["cart"];

        foreach($cart as $p){
            if($p[0] === $id){
                $p[2] = $quantity;
            }
        }

        $_SESSION["cart"] = $cart;
    }
}

function addToCart($id, $price, $quantity, $db)
{
    if(checkLogin()){
        $prod = array($id, $price, $quantity);

        session_start();
        $cart = $_SESSION["cart"];
        array_push($cart, $prod);

        $_SESSION["cart"] = $cart;
    }
}

function checkLogin()
{
    $session = new Session();
    return $session->isLoggedIn();
}

?>