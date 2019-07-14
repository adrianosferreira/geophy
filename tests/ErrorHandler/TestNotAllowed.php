<?php

namespace Tests\ErrorHandler;

use App\Handlers\NotAllowed;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestNotAllowed extends TestCase {

	/**
	 * @test
	 */
	public function itGetsError() {
		$response = $this->getMockBuilder( ResponseInterface::class )->setMethods( array( 'withJson', 'getStatusCode', 'withStatus', 'getReasonPhrase', 'getProtocolVersion', 'withProtocolVersion', 'getHeaders', 'hasHeader', 'getHeader', 'getHeaderLine', 'withHeader', 'withAddedHeader', 'withoutHeader', 'getBody', 'withBody' ) )->disableOriginalConstructor()->getMock();
		$request = $this->getMockBuilder( ServerRequestInterface::class )->disableOriginalConstructor()->getMock();

		$response->method( 'withJson' )
		         ->with( [ 'error' => 'Method not allowed' ], 405 )
		         ->willReturn( $response );

		$response->method( 'withHeader' )
		         ->with( 'Content-type', 'application/json' )
		         ->willReturn( $response );

		$subject = new NotAllowed();
		$this->assertEquals( $response, $subject->getError( $request, $response ) );
	}

	/**
	 * @test
	 */
	public function itGetsKey() {
		$subject = new NotAllowed();
		$this->assertEquals( 'notAllowedHandler', $subject->getKey() );
	}
}