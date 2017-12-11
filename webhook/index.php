<?php

include 'config.php';
include 'functions.php';

$hub_verify_token = null;

if(isset($_REQUEST['hub_challenge'])) {
	$challenge = $_REQUEST['hub_challenge'];
	$hub_verify_token = $_REQUEST['hub_verify_token'];
}

if($hub_verify_token === $verify_token) {
	echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);

$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$userHasCart = userHasCart($sender);
if(isset($input['entry'][0]['messaging'][0]['message'])) {
	if($userHasCart === false) {
		$response = ["text"=>"Veuillez tout d'abord scanner un code messenger. C'est pour mieux vous servir mon enfant!"];
		reply($response, $sender);
	} else {
		$message = $input['entry'][0]['messaging'][0]['message']['text'];
		handleMessage($sender, $message);
	}
} elseif (isset($input['entry'][0]['messaging'][0]['postback'])) {
	$payload = $input['entry'][0]['messaging'][0]['postback']['payload'];
	if(isset($input['entry'][0]['messaging'][0]['postback']['referral'])) {
		if($userHasCart === false) {
			$table_id = $input['entry'][0]['messaging'][0]['postback']['referral']['ref'];
			$timestamp = time();
			setCart($sender, $timestamp, $table_id);
		}
		handlePostback($sender, $payload);
	} else {
		if($userHasCart === false) {
			$response = ["text"=>"Veuillez tout d'abord scanner un code messenger... C'est pour mieux vous servir mon enfant!"];
			reply($response, $sender);
		} else {
			handlePostback($sender, $payload);
		}
	}
} elseif(isset($input['entry'][0]['messaging'][0]['referral'])) {
	if($userHasCart === false) {
		$timestamp = time();
		$table_id = $input['entry'][0]['messaging'][0]['referral']['ref'];
		setCart($sender, $timestamp, $table_id);
	}
	$response = ["text"=>"Merci d'avoir scanné votre code messenger. Vous pouvez maintenant commander :-)"];
	reply($response, $sender);
}
