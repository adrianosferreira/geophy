<?php

namespace App\Services\Attom;

use App\Models\School;

class Schools implements RequestInterface {

	private $request;

	public function __construct( Request $request ) {
		$this->request = $request;
	}

	public function getByPropertyId( int $propertyId ): array {
		$result = $this->request->get(
			'https://api.gateway.attomdata.com/propertyapi/v1.0.0/property/detailwithschools',
			array( 'id' => $propertyId )
		);

		return array_key_exists( 'property', $result ) ? $this->toObject( $result['property'][0]['school'] ) : [];
	}

	public function toObject( $data ): array {
		$result = [];

		foreach( $data as $school ) {
			$result[] = ( new School() )
				->setId( $school['OBInstID'] )
				->setName( $school['InstitutionName'] )
				->setDistance( $school['distance'] )
				->setGradeLevel( $school['gradelevel1lotext'] );
		}

		return $result;
	}
}