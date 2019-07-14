<?php

namespace Tests\Services\Attom;

use App\Models\Sale;
use App\Services\Attom\Request;
use App\Services\Attom\SalesHistory;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class TestSalesHistory extends TestCase {

	/**
	 * @test
	 */
	public function itGetsByPropertyId() {
		$request = $this->getMockBuilder( Request::class )
		                ->disableOriginalConstructor()
		                ->getMock();

		$result = [
			'property' => [
				[
					'salehistory' => [
						[
							'amount' => [
								'saleamt' => 1,
								'saletranstype' => 2,
								'saledocnum' => 3,
							],
							'calculation' => [
								'priceperbed' => 4,
								'pricepersizeunit' => 5,
							],
						],
					],
				],
			],
		];


		$request->method('get' )
		        ->with( 'https://api.gateway.attomdata.com/propertyapi/v1.0.0/saleshistory/snapshot', array( 'id' => 123 ) )
		        ->willReturn( $result );

		$sale = \Mockery::mock( 'overload:' . Sale::class );

		$sale->shouldReceive( 'setAmount' )
		         ->with( 1 )
		         ->andReturn($sale );

		$sale->shouldReceive( 'setTransType' )
		         ->with( 2 )
		         ->andReturn($sale );

		$sale->shouldReceive( 'setDocument' )
		         ->with( 3 )
		         ->andReturn($sale );

		$sale->shouldReceive( 'setPricePerBed' )
		         ->with( 4 )
		         ->andReturn($sale );

		$sale->shouldReceive( 'setPricePerSizeUnit' )
		         ->with( 5 )
		         ->andReturn($sale );

		$subject = new SalesHistory( $request );
		$this->assertEquals( array( $sale ), $subject->getByPropertyId( 123 ) );
	}
}