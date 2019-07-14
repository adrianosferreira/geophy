<?php

namespace App\Services\Attom;

use App\Models\Property;

class Properties implements RequestInterface {

	private $request;

	public function __construct( Request $request ) {
		$this->request = $request;
	}

	public function getByZip( $zip ): array {
		$result = $this->request->get(
			'https://api.gateway.attomdata.com/propertyapi/v1.0.0/property/address',
			$zip ? array( 'postalcode' => $zip ) : [],
			array( '' )
		);

		return array_key_exists( 'property', $result ) ? $this->toObject( $result['property'] ) : [];
	}

	public function toObject( $data ): array {
		$result = [];

		foreach( $data as $property ) {
			$result[] = ( new Property() )
				->setAddress( $property['address']['oneLine'] )
				->setCountry( $property['address']['country'] )
				->setZip( $property['address']['postal1'] )
				->setId( $property['identifier']['obPropId'] );
		}

		return $result;
	}
}