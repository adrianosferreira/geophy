<?php

namespace Tests\ErrorHandler;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestNotFound extends TestCase {

	/**
	 * @test
	 */
	public function itGetsError() {
		$response = $this->getMockBuilder( ResponseInterface::class )->setMethods( array( 'withJson', 'getStatusCode', 'withStatus', 'getReasonPhrase', 'getProtocolVersion', 'withProtocolVersion', 'getHeaders', 'hasHeader', 'getHeader', 'getHeaderLine', 'withHeader', 'withAddedHeader', 'withoutHeader', 'getBody', 'withBody' ) )->disableOriginalConstructor()->getMock();
		$request = $this->getMockBuilder( ServerRequestInterface::class )->disableOriginalConstructor()->getMock();

		$response->method( 'withJson' )
			->with( [ 'error' => 'Route not found' ], 404 )
			->willReturn( $response );

		$response->method( 'withHeader' )
		         ->with( 'Content-type', 'application/json' )
		         ->willReturn( $response );

		$subject = new \App\Handlers\NotFound();
		$this->assertEquals( $response, $subject->getError( $request, $response ) );
	}

	/**
	 * @test
	 */
	public function itGetsKey() {
		$subject = new \App\Handlers\NotFound();
		$this->assertEquals( 'notFoundHandler', $subject->getKey() );
	}
}