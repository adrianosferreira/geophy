<?php

namespace Tests\Services\Attom;

use App\Models\School;
use App\Services\Attom\Request;
use App\Services\Attom\Schools;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class TestSchools {

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
					'school' => [
						[
							'OBInstID'          => 1,
							'InstitutionName'   => 2,
							'distance'          => 3,
							'gradelevel1lotext' => 4
						],
					],
				],
			],
		];


		$request->method('get' )
		        ->with( 'https://api.gateway.attomdata.com/propertyapi/v1.0.0/saleshistory/snapshot', array( 'id' => 123 ) )
		        ->willReturn( $result );

		$school = \Mockery::mock( 'overload:' . School::class );

		$school->shouldReceive( 'setId' )
		         ->with( 1 )
		         ->andReturn($school );

		$school->shouldReceive( 'setName' )
		         ->with( 2 )
		         ->andReturn($school );

		$school->shouldReceive( 'setDistance' )
		         ->with( 3 )
		         ->andReturn($school );

		$school->shouldReceive( 'setGradeLevel' )
		         ->with( 4 )
		         ->andReturn($school );

		$subject = new Schools( $request );
		$this->assertEquals( array( $school ), $subject->getByPropertyId( 123 ) );
	}
}