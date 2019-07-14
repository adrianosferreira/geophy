<?php

namespace App\Handlers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NotAllowed extends ErrorHandler {

	public function getError( ServerRequestInterface $request, ResponseInterface $response ): ResponseInterface {
		return $response->withJson( [ 'error' => 'Method not allowed' ], 405 )->withHeader( 'Content-type', 'application/json' );
	}

	public function getKey(): string {
		return 'notAllowedHandler';
	}
}