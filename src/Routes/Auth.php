<?php

namespace App\Routes;

use App\Authentication\JwtAuthentication;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Auth implements RouteInterface {

	public const PATH = 'v1/auth';
	private $route;

	public function __construct( Route $route ) {
		$this->route = $route;
	}

	public function register(): void {
		$this->route->register( self::PATH, 'get', array( $this, 'callback' ) );
	}

	public function callback( ServerRequestInterface $request, ResponseInterface $response ): ResponseInterface {
		$token = array(
			'user'     => $request->getHeader( 'username' ),
			'password' => $request->getHeader( 'password' ),
		);

		$jwt = \Firebase\JWT\JWT::encode( $token, JwtAuthentication::SECRET );
		return $this->route->response( $request, $response, [ 'token' => $jwt ], array() );
	}
}