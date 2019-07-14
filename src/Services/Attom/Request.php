<?php

namespace App\Services\Attom;

use GuzzleHttp\Client;

class Request {

	protected $client;

	public function __construct( Client $client ) {
		$this->client = $client;
	}

	public function get( string $url, array $parameters ): array {

		if ( $parameters ) {
			$url = http_build_url( $url, array( 'query' => http_build_query( $parameters ) ) );
		}

		try {
			$res = $this->client->get( $url, $this->getHeaders() );
			return json_decode( $res->getBody()->getContents(), true );

		} catch ( \Exception $e ) {
			return [ 'error' => $e->getMessage() ];
		}
	}

	private function getHeaders(): array {
		return [
			'headers' => [
				'apikey' => '63eaa33de129c806a80ee965d89d8fdf',
				'Accept' => 'application/json',
			]
		];
	}
}