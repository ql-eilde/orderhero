<?php

$db = mysqli_connect('localhost', 'root', 'root', 'barbot');
if(!$db) {
	die('Erreur de connexion (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}