<?php

namespace App\Routes;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

class Route {

	public const BASE = 'api';
	private $app;

	public function __construct( App $app ) {
		$this->app = $app;
	}

	public function register( string $path, string $method, callable $callback ): void {
		$path = sprintf( '/%s/%s', self::BASE, $path );
		$this->app->{$method}( $path, $callback );
	}

	public function response( ServerRequestInterface $request, ResponseInterface $response, $body, array $allowedParams ): ResponseInterface {
		$invalidParams = $this->getInvalidParams( $request->getQueryParams(), $allowedParams );

		if ( $invalidParams ) {
			return $this->error( $response, sprintf( 'Invalid parameter: %s', implode( $invalidParams, ', ' ) ) );
		}

		return $response->withJson( $body, 200 )
		                ->withHeader( 'Content-type', 'application/json' );
	}

	public function error( $response, $message ) {
		return $response->withJson( array( 'error' => $message ), 405 )
		                ->withHeader( 'Content-type', 'application/json' );
	}

	private function getInvalidParams( array $params, array $allowed ): array {
		$invalidParameters = [];

		foreach ( $params as $key => $param ) {
			if ( ! \in_array( $key, $allowed, true ) ) {
				$invalidParameters[] = $key;
			}
		}

		return $invalidParameters;
	}
}