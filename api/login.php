<?php

if ( !isset ($_POST['username'], $_POST['password'], $_POST['Token']) ){
	exit(header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"));
}


require_once '../core/init.php';
use Greedy\Form\Token as Token;

if ( !Token::check($_POST['Token']) )
	exit(header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"));


echo json_encode(['login' => 'true', 'username' => $_POST['username']]);

