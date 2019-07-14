<?php

namespace App\Routes;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RouteInterface {

	public function register(): void;
	public function callback( ServerRequestInterface $request, ResponseInterface $response ): ResponseInterface;
}