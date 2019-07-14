<?php

namespace Tests\Routes;

use App\Routes\Route;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

class TestRoute extends TestCase {

	/**
	 * @test
	 */
	public function itRegistersRoute() {
		$app = $this->getMockBuilder( App::class )
			->disableOriginalConstructor()
			->getMock();

		$subject = new Route( $app );

		$callback = function(){};

		$app->expects( $this->once() )
		    ->method( 'get' )
			->with( '/api/v1/auth', $callback );

		$subject->register( 'v1/auth', 'get', $callback );
	}

	/**
	 * @test
	 */
	public function itRespondsWithErrorWhenItContainsInvalidParameter() {
		$app = $this->getMockBuilder( App::class )
		            ->disableOriginalConstructor()
		            ->getMock();

		$subject = new Route( $app );

		$callback = function(){};

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

		$request->method( 'getQueryParams' )
			->willReturn( array( 'invalidParam' => 'test' ) );

		$response->method( 'withJson' )
			->with( array( 'error' => sprintf( 'Invalid parameter: %s', 'invalidParam' ) ), 405 )
			->willReturn( $response );

		$body = 'some body';

		$this->assertEquals( $response, $subject->response( $request, $response, $body, array( 'something' ) ) );
	}

	/**
	 * @test
	 */
	public function itRespondsSuccessWhenParametersAreValid() {
		$app = $this->getMockBuilder( App::class )
		            ->disableOriginalConstructor()
		            ->getMock();

		$subject = new Route( $app );

		$callback = function(){};

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

		$request->method( 'getQueryParams' )
		        ->willReturn( array( 'something' => 'test' ) );

		$body = 'some body';

		$response->method( 'withJson' )
		         ->with( $body, 200 )
		         ->willReturn( $response );

		$this->assertEquals( $response, $subject->response( $request, $response, $body, array( 'something' ) ) );
	}
}