<?php

namespace Tests\Services\Attom;

use App\Models\Property;
use App\Services\Attom\Properties;
use App\Services\Attom\Request;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class TestProperties extends TestCase {

	/**
	 * @test
	 */
	public function itGetsByZip() {
		$request = $this->getMockBuilder( Request::class )
			->disableOriginalConstructor()
			->getMock();

		$result = [
			'property' => [
				[
					'address' => [
						'oneLine' => 'address',
						'country' => 'US',
						'postal1' => 456,
					],
					'identifier' => [
						'obPropId' => 123,
					],
				]
			],
		];

		$zip = 1111111;

		$request->method('get' )
			->with( 'https://api.gateway.attomdata.com/propertyapi/v1.0.0/property/address', array( 'postalcode' => $zip ) )
			->willReturn( $result );

		$property = \Mockery::mock( 'overload:' . Property::class );

		$property->shouldReceive( 'setAddress' )
			->with( 'address' )
			->andReturn($property );

		$property->shouldReceive( 'setCountry' )
		         ->with( 'US' )
		         ->andReturn($property );

		$property->shouldReceive( 'setZip' )
		         ->with( 456 )
		         ->andReturn($property );

		$property->shouldReceive( 'setId' )
		         ->with( 123 )
		         ->andReturn($property );

		$subject = new Properties( $request );
		$this->assertEquals( array( $property ), $subject->getByZip( $zip ) );
	}
}