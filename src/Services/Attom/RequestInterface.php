<?php

namespace App\Services\Attom;

interface RequestInterface {

	public function __construct( Request $request );
	public function toObject( $data ): array;
}