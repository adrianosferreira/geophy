<?php

namespace App\Handlers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NotFound extends ErrorHandler {

	public function getError( ServerRequestInterface $request, ResponseInterface $response ): ResponseInterface {
		return $response->withJson( [ 'error' => 'Route not found' ], 404 )->withHeader( 'Content-type', 'application/json' );
	}

	public function getKey(): string {
		return 'notFoundHandler';
	}
}