<?php

namespace App\Authentication;

use App\Routes\Auth;
use App\Routes\Route;
use Psr\Http\Server\MiddlewareInterface;

class JwtAuthentication {

	public const SECRET = 'Yufk%67kd43dTRyA--__08kKglTi';

	public function get(): MiddlewareInterface {
		return new \Tuupola\Middleware\JwtAuthentication(
			[
		         'path'   => [ '/' . Route::BASE ],
		         'header' => 'X-Token',
		         'ignore' => [ '/' . Route::BASE . '/' . Auth::PATH ],
		         'regexp' => '/(.*)/',
		         'secret' => self::SECRET,
		         'error' => array( $this, 'getErrorCallback' ),
		         'secure' => false,
		     ]
		);
	}

	public function getErrorCallback( $response, $arguments ) {
		$data['status']  = 'error';
		$data['message'] = $arguments['message'];

		return $response->withHeader( 'Content-Type', 'application/json' )
		                ->getBody()
		                ->write( json_encode( $data ) );
	}
}