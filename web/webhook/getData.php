<?php

// function getMenuPayloads($db) {
// 	$requete = "SELECT `payload` FROM `bar_menu`";

// 	if($query = mysqli_query($db, $requete)) {
// 		for($resultat = array();$row = mysqli_fetch_assoc($query);$resultat[] = $row);
// 		mysqli_free_result($query);
// 	}

// 	foreach($resultat as $value) {
// 		$menuPayloads[] = $value['payload'];
// 	}

// 	return $menuPayloads;
// }

// function getProductsPayloads($db) {
// 	$requete = "SELECT `payload` FROM `bar_product`";

// 	if($query = mysqli_query($db, $requete)) {
// 		for($resultat = array();$row = mysqli_fetch_assoc($query);$resultat[] = $row);
// 		mysqli_free_result($query);
// 	}

// 	foreach($resultat as $value) {
// 		$productsPayloads[] = $value['payload'];
// 	}

// 	return $productsPayloads;
// }

function getProducts($payload, $db) {
	if(preg_match("/^show/", $payload) === 1) {
		$payload = "first_page:".$payload;
	}
	$requete = "
		SELECT `title`,`subtitle`,`price`,`payload`
		FROM `bar_product`
		WHERE `location` = '$payload'
		LIMIT 4
	";

	if($query = mysqli_query($db, $requete)) {
		for($data = array();$row = mysqli_fetch_assoc($query);$data[] = $row);
		mysqli_free_result($query);
	}
	
	return $data;
}

function getProduct($payload, $db) {
	$requete = "
		SELECT *
		FROM `bar_product`
		WHERE `payload` = '$payload'
		LIMIT 1
	";

	if($query = mysqli_query($db, $requete)) {
		$data = mysqli_fetch_assoc($query);
		mysqli_free_result($query);
	}

	return $data;
}

// function getMenu($location, $db) {
// 	$requete = "
// 		SELECT `title`,`subtitle`,`payload`
// 		FROM `bar_menu`
// 		WHERE `location` = '$location'
// 		LIMIT 4
// 	";

// 	if($query = mysqli_query($db, $requete)) {
// 		for($data = array();$row = mysqli_fetch_assoc($query);$data[] = $row);
// 		mysqli_free_result($query);
// 	}

// 	return $data;
// }

// function getMenuLocations($db) {
// 	$requete = "SELECT DISTINCT `location` FROM `bar_menu`";

// 	if($query = mysqli_query($db, $requete)) {
// 		for($resultat = array();$row = mysqli_fetch_assoc($query);$resultat[] = $row);
// 		mysqli_free_result($query);
// 	}

// 	foreach($resultat as $value) {
// 		$menuLocations[] = $value['location'];
// 	}

// 	return $menuLocations;
// }

function getProductsLocations($db) {
	$requete = "SELECT DISTINCT `location` FROM `bar_product`";

	if($query = mysqli_query($db, $requete)) {
		for($resultat = array();$row = mysqli_fetch_assoc($query);$resultat[] = $row);
		mysqli_free_result($query);
	}

	foreach($resultat as $value) {
		$productsLocations[] = $value['location'];
	}

	return $productsLocations;
}

// function getTotalOfCart($sender, $db) {
// 	$requete = "
// 		SELECT `total`
// 		FROM `bar_cart`
// 		WHERE `customer_id` = '$sender'
// 	";

// 	if($query = mysqli_query($db, $requete)) {
// 		$data = mysqli_fetch_assoc($query);
// 		mysqli_free_result($query);
// 	}

// 	return $data;
// }

// function userHasCart($psid, $db) {
// 	$requete = "
// 		SELECT `id`
// 		FROM `bar_cart`
// 		WHERE `customer_id` = '$psid'
// 	";

// 	if($query = mysqli_query($db, $requete)) {
// 		$num_rows = mysqli_num_rows($query);
// 		mysqli_free_result($query);
// 		if($num_rows === 0) {
// 			return false;
// 		}
// 		return true;
// 	}
// }