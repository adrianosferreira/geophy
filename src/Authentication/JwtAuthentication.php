<?php

namespace App\Authentication;

use Psr\Http\Server\MiddlewareInterface;

class JwtAuthentication {

	public const SECRET = 'Yufk%67kd43dTRyA--__08kKglTi';

	public function get(): MiddlewareInterface {
		return new \Tuupola\Middleware\JwtAuthentication(
			[
		         'path'   => [ '/api' ],
		         'header' => 'X-Token',
		         'ignore' => [ '/api/v1/auth' ],
		         'regexp' => '/(.*)/',
		         'secret' => self::SECRET,
		     ]
		);
	}
}