<?php

namespace Tests\Authentication;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class TestJwtAuthentication extends TestCase {

	/**
	 * @test
	 */
	public function itGetsAuthenticator() {
		$subject = new \App\Authentication\JwtAuthentication();
		$this->assertInstanceOf( \Tuupola\Middleware\JwtAuthentication::class, $subject->get() );
	}

	/**
	 * @test
	 */
	public function itGetsErrorCallback() {
		$subject  = new \App\Authentication\JwtAuthentication();
		$response = $this->getMockBuilder( ResponseInterface::class )->disableOriginalConstructor()->getMock();

		$response->method( 'withHeader' )->with( 'Content-Type', 'application/json' )->willReturn( $response );

		$arguments = [ 'message' => 'message' ];

		$data['status']  = 'error';
		$data['message'] = 'message';

		$body = $this->getMockBuilder( StreamInterface::class )
			->setMethods( array( 'write', '__toString', 'close', 'detach', 'getSize', 'tell', 'eof', 'isSeekable', 'seek', 'rewind', 'isWritable', 'read', 'getContents', 'getMetadata', 'isReadable' ) )
			->getMock();

		$body->method( 'write' )
			->with( json_encode( $data ) )
			->willReturn( $response );

		$response->method( 'getBody' )
			->willReturn( $body );

		$this->assertEquals( $response, $subject->getErrorCallback( $response, $arguments ) );
	}
}