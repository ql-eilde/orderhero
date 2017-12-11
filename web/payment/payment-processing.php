<?php

require_once('stripe/init.php');
include 'cart.php';
include 'order.php';

\Stripe\Stripe::setApiKey("sk_test_e4och37Zjax9BEl0OBIwF5dN");

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['stripeToken'];
    $psid = $_POST['psid'];
    $cart = getCart($psid);
    $amount = floatval($cart['total']) * 100;

    try {
        $charge = \Stripe\Charge::create(array(
            "amount" => $amount,
            "currency" => "eur",
            "description" => "Paiement Barbot",
            "source" => $token,
        ));
        setOrder($cart, $charge->id);
        $cartItems = getCartItems($cart);
        foreach($cartItems as $item) {
            setOrderItem($item, $charge->id);
        }
        deleteCart($cart['id']);
        header('Location: html/success.html');
        die();
    } catch(\Stripe\Error\Card $e) {
        header('Location: html/failure.html');
        die();
    }
}
?>