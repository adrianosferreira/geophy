<?php

namespace App\Services\Attom;

use App\Models\Sale;

class SalesHistory implements RequestInterface {

	private $request;

	public function __construct( Request $request ) {
		$this->request = $request;
	}

	public function getByPropertyId( int $propertyId ): array {
		$result = $this->request->get(
			'https://api.gateway.attomdata.com/propertyapi/v1.0.0/saleshistory/snapshot',
			array( 'id' => $propertyId )
		);

		return $this->toObject( $result['property'][0]['salehistory'] ) ?? [];
	}

	public function toObject( $data ): array {
		$result = [];

		foreach( $data as $sale ) {
			$result[] = ( new Sale() )
				->setAmount( $sale['amount']['saleamt'] ?? '' )
				->setTransType( $sale['amount']['saletranstype'] ?? 0 )
				->setDocument( $sale['amount']['saledocnum'] ?? 0 )
				->setPricePerBed( $sale['calculation']['priceperbed'] ?? 0 )
				->setPricePerSizeUnit( $sale['calculation']['pricepersizeunit'] ?? 0 );
		}

		return $result;
	}
}