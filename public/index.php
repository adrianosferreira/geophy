<?php

require __DIR__ . '/../vendor/autoload.php';

session_start();

$container = [
	'settings' => [
		'displayErrorDetails'    => true,
		'addContentLengthHeader' => false,
	],
];

$container = ( new \App\Handlers\NotFound() )->apply( $container );
$container = ( new \App\Handlers\NotAllowed() )->apply( $container );

$app = new \Slim\App( $container );

$app->add( ( new \App\Authentication\JwtAuthentication() )->get() );

$routeRegistration = new \App\Routes\Route( $app );
$requestHandler = new \App\Services\Attom\Request( new \GuzzleHttp\Client() );

( new \App\Routes\Properties(
	$routeRegistration,
	new \App\Services\Attom\Properties( $requestHandler ),
	new \App\Services\Attom\SalesHistory( $requestHandler ),
	new \App\Services\Attom\Schools( $requestHandler )
) )->register();

( new \App\Routes\Auth( $routeRegistration ) )->register();

$app->run();