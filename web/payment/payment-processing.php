<?php

$db = mysqli_connect('localhost', 'root', 'BCGA1203ql;', 'orderhero');
if(!$db) {
	die('Erreur de connexion (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}

require_once('stripe/init.php');
include 'cart.php';
include 'order.php';

\Stripe\Stripe::setApiKey("sk_test_e4och37Zjax9BEl0OBIwF5dN");

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['stripeToken'];
    $psid = $_POST['psid'];
    $cart = getCart($psid, $db);
    $amount = floatval($cart['total']) * 100;

    try {
        $charge = \Stripe\Charge::create(array(
            "amount" => $amount,
            "currency" => "eur",
            "description" => "Paiement Barbot",
            "source" => $token,
        ));
        setOrder($cart, $charge->id, $db);
        $cartItems = getCartItems($cart, $db);
        foreach($cartItems as $item) {
            setOrderItem($item, $charge->id, $db);
        }
        deleteCart($cart['id'], $db);
        header('Location: html/success.html');
        die();
    } catch(\Stripe\Error\Card $e) {
        header('Location: html/failure.html');
        die();
    }
}
?>