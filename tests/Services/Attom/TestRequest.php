<?php

namespace Tests\Services\Attom;

use App\Services\Attom\Request;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class TestRequest extends TestCase {

	/**
	 * @test
	 */
	public function itGetsWithParameters() {
		$client = $this->getMockBuilder( Client::class )
			->setMethods( array( 'get' ) )
			->disableOriginalConstructor()
			->getMock();

		$url = 'http://something.com';
		$parameters = array( 'id' => 123 );

		$res = $this->getMockBuilder( \stdClass::class )
			->setMethods( array( 'getBody', 'getContents' ) )
			->disableOriginalConstructor()
			->getMock();

		$res->method( 'getBody' )
			->willReturn( $res );

		$content = json_encode( array( 'something' => 1 ) );

		$client->method( 'get' )
			->with( 'http://something.com?id=123', [
				'headers' => [
					'apikey' => '63eaa33de129c806a80ee965d89d8fdf',
					'Accept' => 'application/json',
				]
			] )
			->willReturn( $res );

		$res->method( 'getContents' )
		    ->willReturn( $content );

		$subject = new Request( $client );
		$this->assertEquals( array( 'something' => 1 ), $subject->get( $url, $parameters ) );
	}

	/**
	 * @test
	 */
	public function itGetsWithoutParameters() {
		$client = $this->getMockBuilder( Client::class )
		               ->setMethods( array( 'get' ) )
		               ->disableOriginalConstructor()
		               ->getMock();

		$url = 'http://something.com';
		$parameters = array();

		$res = $this->getMockBuilder( \stdClass::class )
		            ->setMethods( array( 'getBody', 'getContents' ) )
		            ->disableOriginalConstructor()
		            ->getMock();

		$res->method( 'getBody' )
		    ->willReturn( $res );

		$content = json_encode( array( 'something' => 1 ) );

		$client->method( 'get' )
		       ->with( 'http://something.com', [
			       'headers' => [
				       'apikey' => '63eaa33de129c806a80ee965d89d8fdf',
				       'Accept' => 'application/json',
			       ]
		       ] )
		       ->willReturn( $res );

		$res->method( 'getContents' )
		    ->willReturn( $content );

		$subject = new Request( $client );
		$this->assertEquals( array( 'something' => 1 ), $subject->get( $url, $parameters ) );
	}

	/**
	 * @test
	 */
	public function itReturnsErrorWhenExceptionIsThrown() {
		$client = $this->getMockBuilder( Client::class )
		               ->setMethods( array( 'get' ) )
		               ->disableOriginalConstructor()
		               ->getMock();

		$url = 'http://something.com';
		$parameters = array();

		$res = $this->getMockBuilder( \stdClass::class )
		            ->setMethods( array( 'getBody', 'getContents' ) )
		            ->disableOriginalConstructor()
		            ->getMock();

		$res->method( 'getBody' )
		    ->willReturn( $res );

		$content = json_encode( array( 'something' => 1 ) );

		$client->method( 'get' )
		       ->with( 'http://something.com', [
			       'headers' => [
				       'apikey' => '63eaa33de129c806a80ee965d89d8fdf',
				       'Accept' => 'application/json',
			       ]
		       ] )
		       ->willReturnCallback( function() {
		       	    throw new \Exception( 'message' );
		       } );

		$res->method( 'getContents' )
		    ->willReturn( $content );

		$subject = new Request( $client );
		$this->assertEquals( array( 'error' => 'message' ), $subject->get( $url, $parameters ) );
	}
}