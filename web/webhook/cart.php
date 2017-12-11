<?php

function addToCart($sender, $product) {
	$cart = getCart($sender);
	setCartItem($product, $cart['id']);
	setCartTotal($cart);
}

function getCart($sender) {
	include '../db.php';
	$sender = intval($sender);
	$requete = "
		SELECT *
		FROM `bar_cart`
		WHERE `customer_id` = $sender
	";

	if($query = mysqli_query($db, $requete)) {
		$data = mysqli_fetch_assoc($query);
		mysqli_free_result($query);
	}

	return $data;
}

function setCart($sender, $timestamp, $table_id) {
	include '../db.php';
	$requete = "
		INSERT INTO `bar_cart` (`customer_id`,`table_id`,`timestamp`)
		VALUES (?,?,?)
	";
	
	if($stmt = mysqli_prepare($db, $requete)) {
		mysqli_stmt_bind_param($stmt, "ssi", $sender, $table_id, $timestamp);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}

function setCartTotal($cart) {
	$total = getCartTotal($cart);
	include '../db.php';
	$requete = "
		UPDATE `bar_cart`
		SET `total` = ?
		WHERE `id` = ?
	";

	if($stmt = mysqli_prepare($db, $requete)) {
		mysqli_stmt_bind_param($stmt, "ss", $total, $cart['id']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}

function getCartTotal($cart) {
	$cartItems = getCartItems($cart);

	$total_array = array();
	foreach($cartItems as $item) {
		$total_array[] = $item['total'];
	}
	$total = array_sum($total_array);
	
	return $total;
}

function setCartItem($product, $cartId) {
	include '../db.php';
	$cartId = intval($cartId);
	$requete= "
		INSERT INTO `bar_cart_item` (`bar_cart_id`,`bar_product_id`,`quantity`,`price`,`tax`,`total`)
		VALUES (?,?,?,?,?,?)
	";

	if($stmt = mysqli_prepare($db, $requete)) {
		$quantity = 1;
		mysqli_stmt_bind_param($stmt, "isisss", $cartId, $product['id'], $quantity, $product['price'], $product['tax'], $product['price']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}

function getCartItems($cart) {
	include '../db.php';
	$id = $cart['id'];
	$requete = "
		SELECT *
		FROM `bar_cart_item`
		WHERE `bar_cart_id` = $id
	";

	if($query = mysqli_query($db, $requete)) {
		for($data = array();$row = mysqli_fetch_assoc($query);$data[] = $row);
		mysqli_free_result($query);
	}

	return $data;
}

function deleteCart($cartId) {
	include '../db.php';
	$requete = "
		DELETE FROM `bar_cart`
		WHERE `id` = ?
	";

	if($stmt = mysqli_prepare($db, $requete)) {
		mysqli_stmt_bind_param($stmt, "s", $cartId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}

function deleteCartItems($cartId) {
	include '../db.php';
	$requete = "
		DELETE FROM `bar_cart_item`
		WHERE `bar_cart_id` = ?
	";

	if($stmt = mysqli_prepare($db, $requete)) {
		mysqli_stmt_bind_param($stmt, "s", $cartId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}