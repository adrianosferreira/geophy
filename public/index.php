<?php

require __DIR__ . '/../vendor/autoload.php';

session_start();

$container = [
	'settings'  => [
		'displayErrorDetails'    => true,
		'addContentLengthHeader' => false,
	],
];

$app = new \Slim\App( $container );

$app->add( ( new \App\Authentication\JwtAuthentication() )->get() );

( new \App\Routes\Auth( $app ) )->register();

$app->run();