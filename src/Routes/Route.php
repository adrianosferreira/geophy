<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 11/07/19
 * Time: 16:51
 */

namespace App\Routes;

abstract class Route {

	const BASE = 'api';

	public function __construct( \Slim\App $app ) {
		$this->app = $app;
	}

	public function register(): void {
		$this->app->{ $this->getMethod() }( '/' . self::BASE . '/' . $this->getVersion() . '/' . $this->getPath(), array( $this, 'getCallback' ));
	}

	abstract protected function getMethod(): string;
	abstract protected function getPath(): string;
	abstract protected function getCallback( \Slim\Http\Request $request, \Slim\Http\Response $response  );
	abstract protected function getVersion(): string;
}