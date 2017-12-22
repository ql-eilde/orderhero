<?php

function setOrder($cart, $chargeId, $db) {
    $requete = "
        INSERT INTO `bar_order` (`charge_id`,`customer_id`,`timestamp`,`table_id`,`total`)
        VALUES (?,?,?,?,?)
    ";
    $timestamp = time();

    if($stmt = mysqli_prepare($db, $requete)) {
		mysqli_stmt_bind_param($stmt, "ssiss", $chargeId, $cart['customer_id'], $timestamp, $cart['table_id'], $cart['total']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
}

function getOrder($chargeId, $db) {
    $requete = "
        SELECT *
        FROM `bar_order`
        WHERE `charge_id` = '$chargeId'
        LIMIT 1
    ";

    if($query = mysqli_query($db, $requete)) {
        $data = mysqli_fetch_assoc($query);
        mysqli_free_result($query);
	}

	return $data;
}

function setOrderItem($item, $chargeId, $db) {
    $requete = "
        INSERT INTO `bar_order_item` (`bar_order_id`,`bar_product_id`,`quantity`,`price`,`tax`,`total`)
        VALUES (?,?,?,?,?,?)
    ";
    $order = getOrder($chargeId, $db);

    if($stmt = mysqli_prepare($db, $requete)) {
        mysqli_stmt_bind_param($stmt, "ssssss", $order['id'], $item['bar_product_id'], $item['quantity'], $item['price'], $item['tax'], $item['total']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}