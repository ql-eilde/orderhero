<?php

function getCart($sender, $db) {
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

function getCartItems($cart, $db) {
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

function deleteCart($cartId, $db) {
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