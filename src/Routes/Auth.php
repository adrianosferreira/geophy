<?php

namespace App\Routes;

use App\Authentication\JwtAuthentication;
use Slim\Http\Response;

class Auth extends Route {

	public function __construct( \Slim\App $app ) {
		parent::__construct( $app );
	}

	protected function getPath(): string {
		return 'auth';
	}

	protected function getMethod(): string {
		return 'get';
	}

	protected function getVersion(): string {
		return 'v1';
	}

	public function getCallback( \Slim\Http\Request $request, \Slim\Http\Response $response ): Response {
		$token = array(
			'user'     => $request->getHeader('username'),
			'password' => $request->getHeader('password'),
		);

		$jwt = \Firebase\JWT\JWT::encode( $token, JwtAuthentication::SECRET );

		return $response->withJson( [ 'auth-jwt' => $jwt ], 200 )->withHeader( 'Content-type', 'application/json' );
	}
}