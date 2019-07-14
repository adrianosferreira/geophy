<?php

namespace App\Handlers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class ErrorHandler {

	public function apply( array $container ): array {
		$container[ $this->getKey() ] = array( $this, 'getError' );

		return $container;
	}

	abstract protected function getKey(): string;
	abstract public function getError( ServerRequestInterface $request, ResponseInterface $response ): ResponseInterface;
}