<?php

namespace App\Routes;

use App\Services\Attom\SalesHistory;
use App\Services\Attom\Schools;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Properties implements RouteInterface {

	public const PATH = 'v1/properties';

	private $route;
	private $properties;
	private $sales;
	private $schools;

	public function __construct( Route $route, \App\Services\Attom\Properties $properties, SalesHistory $sales, Schools $schools ) {
		$this->route      = $route;
		$this->properties = $properties;
		$this->sales      = $sales;
		$this->schools    = $schools;
	}

	public function register(): void {
		$this->route->register( self::PATH, 'get', array( $this, 'callback' ) );
	}

	public function callback( ServerRequestInterface $request, ResponseInterface $response ): ResponseInterface {
		if ( ! $request->getQueryParam( 'zip' ) ) {
			return $this->route->error( $response, 'Required parameter missing: zip' );
		}

		$properties       = $this->properties->getByZip( $request->getQueryParam( 'zip' ) );
		$fullPropertyData = $this->mergePropertyData( $properties );

		return $this->route->response( $request, $response, $fullPropertyData, array( 'zip' ) );
	}

	private function mergePropertyData( array $properties ): array {
		$result = [];
		foreach ( $properties as $property ) {
			$result[] = [
				'propertyData' => $property,
				'salesHistory' => $this->sales->getByPropertyId( $property->getId() ),
				'schools'      => $this->schools->getByPropertyId( $property->getId() )
			];
		}

		return $result;
	}
}