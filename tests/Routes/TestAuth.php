<?php

namespace Tests\Routes;

use App\Routes\Auth;
use App\Routes\Route;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestAuth extends TestCase {

	/**
	 * @test
	 */
	public function itRegistersRoute() {
		$route = $this->getMockBuilder( Route::class )
		              ->disableOriginalConstructor()
		              ->getMock();

		$subject = new Auth( $route );

		$route->expects( $this->once() )
		      ->method( 'register' )
		      ->with( 'v1/auth', 'get', array( $subject, 'callback' ) );

		$subject->register();
	}

	/**
	 * @test
	 */
	public function itRunsCallback() {
		$route = $this->getMockBuilder( Route::class )
		              ->disableOriginalConstructor()
		              ->getMock();

		$subject = new Auth( $route );

		$request = $this->getMockBuilder( ServerRequestInterface::class )
		                ->setMethods(
			                array(
				                'getQueryParam',
				                'getServerParams',
				                'getCookieParams',
				                'withCookieParams',
				                'getQueryParams',
				                'withQueryParams',
				                'getUploadedFiles',
				                'withUploadedFiles',
				                'getParsedBody',
				                'withParsedBody',
				                'getAttributes',
				                'getAttribute',
				                'withAttribute',
				                'withoutAttribute',
				                'getRequestTarget',
				                'withRequestTarget',
				                'getMethod',
				                'withMethod',
				                'getUri',
				                'withUri',
				                'getProtocolVersion',
				                'withProtocolVersion',
				                'getHeaders',
				                'hasHeader',
				                'getHeader',
				                'getHeaderLine',
				                'withHeader',
				                'withAddedHeader',
				                'withoutHeader',
				                'getBody',
				                'withBody'
			                )
		                )
		                ->disableOriginalConstructor()
		                ->getMock();

		$response = $this->getMockBuilder( ResponseInterface::class )
		                 ->setMethods( array( 'withJson', 'getStatusCode', 'withStatus', 'getReasonPhrase', 'getProtocolVersion', 'withProtocolVersion', 'getHeaders', 'hasHeader', 'getHeader', 'getHeaderLine', 'withHeader', 'withAddedHeader', 'withoutHeader', 'getBody', 'withBody' ) )
		                 ->disableOriginalConstructor()
		                 ->getMock();

		$response->method( 'withHeader' )
		         ->willReturn( $response );

		$routeResponse = $this->getMockBuilder( ResponseInterface::class )
		                      ->setMethods( array( 'withJson', 'getStatusCode', 'withStatus', 'getReasonPhrase', 'getProtocolVersion', 'withProtocolVersion', 'getHeaders', 'hasHeader', 'getHeader', 'getHeaderLine', 'withHeader', 'withAddedHeader', 'withoutHeader', 'getBody', 'withBody' ) )
		                      ->disableOriginalConstructor()
		                      ->getMock();

		$route->expects( $this->once() )
		      ->method( 'response' )
		      ->with( $request, $response, $this->isType( 'array' ), array() )
		      ->willReturn( $routeResponse );

		$route->method( 'response' )
		      ->willReturn( $routeResponse );

		$this->assertEquals( $routeResponse, $subject->callback( $request, $response ) );
	}
}