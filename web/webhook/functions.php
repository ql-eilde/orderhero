<?php

include 'templates.php';
include 'getData.php';
include 'cart.php';

function handleMessage($sender, $message, $db) {
	$response = "";
	switch(strtolower($message)) {
		case 'carte':
			$response = showMenu(getMenu("first_menu", $db), "first_menu");
			break;
		default:
			$response = defaultResponse();
	}

	reply($response, $sender);
}

function handlePostback($sender, $payload, $db) {
	$response = "";
	switch($payload) {
		case 'conversation_started':
			$response = welcomeMessage();
			break;
		case 'YesShowMeTheMenu':
		case 'anotherDrink':
			$response = showMenu(getMenu("first_menu", $db), "first_menu");
			break;
		case 'DontShowMeTheMenu':
			$response = dontShowMenu();
			break;
		case 'payMyOrder':
			$total = getTotalOfCart($sender, $db);
			$response = payOrder($sender, $total['total']);
			break;
		default:
			$response = "";
	}
	if($response === "") {
		// TODO: Gerer les fin de menus et produits
		$menuPayloads = getMenuPayloads($db);
		$menuLocations = getMenuLocations($db);
		$productsPayloads = getProductsPayloads($db);
		$productsLocations = getProductsLocations($db);
		switch(true) {
			case in_array($payload, $menuPayloads):
				$location = "first_page:".$payload;
				$response = showProducts(getProducts($payload, $db), $location, $payload);
				break;
			case in_array($payload, $menuLocations):
				$response = showMenu(getMenu($payload, $db), $payload);
				break;
			case in_array($payload, $productsLocations):
				$show = explode(":", $payload);
				$response = showProducts(getProducts($payload, $db), $payload, $show[1]);
				break;
			case in_array($payload, $productsPayloads):
				$product = getProduct($payload, $db);
				addToCart($sender, $product, $db);
				$total = getTotalOfCart($sender, $db);
				$response = anotherDrink($sender, $total['total']);
				break;
			default:
				$response = "";
		}
	}

	reply($response, $sender);
}

function reply($response, $sender) {
	$message = [
		"messaging_type"=>"RESPONSE",
		"recipient"=>[
			"id"=>$sender
		],
		"message"=>$response
	];

	include 'config.php';

	$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$access_token;
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

	curl_exec($ch);
}