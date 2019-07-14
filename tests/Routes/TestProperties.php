<?php

namespace Tests\Routes;

use App\Models\Property;
use App\Routes\Properties;
use App\Routes\Route;
use App\Services\Attom\SalesHistory;
use App\Services\Attom\Schools;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestProperties extends TestCase {

	/**
	 * @test
	 */
	public function itRegistersRoute() {
		$route = $this->getMockBuilder( Route::class )
			->disableOriginalConstructor()
			->getMock();

		$properties = $this->getMockBuilder( \App\Services\Attom\Properties::class )
		              ->disableOriginalConstructor()
		              ->getMock();

		$salesHistory = $this->getMockBuilder( SalesHistory::class )
		              ->disableOriginalConstructor()
		              ->getMock();

		$schools = $this->getMockBuilder( Schools::class )
		              ->disableOriginalConstructor()
		              ->getMock();

		$subject = new Properties( $route, $properties, $salesHistory, $schools );

		$route->expects( $this->once() )
		      ->method( 'register' )
		      ->with( 'v1/properties', 'get', array( $subject, 'callback' ) );

		$subject->register();
	}

	/**
	 * @test
	 */
	public function itRunsCallback() {
		$route = $this->getMockBuilder( Route::class )
		              ->disableOriginalConstructor()
		              ->getMock();

		$properties = $this->getMockBuilder( \App\Services\Attom\Properties::class )
		                   ->disableOriginalConstructor()
		                   ->getMock();

		$salesHistory = $this->getMockBuilder( SalesHistory::class )
		                     ->disableOriginalConstructor()
		                     ->getMock();

		$schools = $this->getMockBuilder( Schools::class )
		                ->disableOriginalConstructor()
		                ->getMock();

		$subject = new Properties( $route, $properties, $salesHistory, $schools );

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

		$property = $this->getMockBuilder( Property::class )
			->disableOriginalConstructor()
			->getMock();

		$property->method( 'getId' )
			->willReturn( 456 );

		$propertiesArr = array(
			$property
		);

		$properties->method( 'getByZip' )
			->with( 123 )
			->willReturn( $propertiesArr );

		$salesHistory->method( 'getByPropertyId' )
			->with( 456 )
			->willReturn( array() );

		$schools->method( 'getByPropertyId' )
		             ->with( 456 )
		             ->willReturn( array() );

		$response->method( 'withHeader' )
		         ->willReturn( $response );

		$request->method( 'getQueryParam' )
			->with( 'zip' )
			->willReturn( 123 );

		$routeResponse = $this->getMockBuilder( ResponseInterface::class )
		                      ->setMethods( array( 'withJson', 'getStatusCode', 'withStatus', 'getReasonPhrase', 'getProtocolVersion', 'withProtocolVersion', 'getHeaders', 'hasHeader', 'getHeader', 'getHeaderLine', 'withHeader', 'withAddedHeader', 'withoutHeader', 'getBody', 'withBody' ) )
		                      ->disableOriginalConstructor()
		                      ->getMock();

		$route->expects( $this->once() )
		      ->method( 'response' )
		      ->with( $request, $response, $this->isType( 'array' ), array( 'zip' ) )
		      ->willReturn( $routeResponse );

		$this->assertEquals( $routeResponse, $subject->callback( $request, $response ) );
	}

	/**
	 * @test
	 */
	public function itReturnsErrorWhenRequiredParamIsNotGiven() {
		$route = $this->getMockBuilder( Route::class )
		              ->disableOriginalConstructor()
		              ->getMock();

		$properties = $this->getMockBuilder( \App\Services\Attom\Properties::class )
		                   ->disableOriginalConstructor()
		                   ->getMock();

		$salesHistory = $this->getMockBuilder( SalesHistory::class )
		                     ->disableOriginalConstructor()
		                     ->getMock();

		$schools = $this->getMockBuilder( Schools::class )
		                ->disableOriginalConstructor()
		                ->getMock();

		$subject = new Properties( $route, $properties, $salesHistory, $schools );

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

		$property = $this->getMockBuilder( Property::class )
		                 ->disableOriginalConstructor()
		                 ->getMock();

		$property->method( 'getId' )
		         ->willReturn( 456 );

		$propertiesArr = array(
			$property
		);

		$properties->method( 'getByZip' )
		           ->with( 123 )
		           ->willReturn( $propertiesArr );

		$salesHistory->method( 'getByPropertyId' )
		             ->with( 456 )
		             ->willReturn( array() );

		$schools->method( 'getByPropertyId' )
		        ->with( 456 )
		        ->willReturn( array() );

		$response->method( 'withHeader' )
		         ->willReturn( $response );

		$routeResponse = $this->getMockBuilder( ResponseInterface::class )
		                      ->setMethods( array( 'withJson', 'getStatusCode', 'withStatus', 'getReasonPhrase', 'getProtocolVersion', 'withProtocolVersion', 'getHeaders', 'hasHeader', 'getHeader', 'getHeaderLine', 'withHeader', 'withAddedHeader', 'withoutHeader', 'getBody', 'withBody' ) )
		                      ->disableOriginalConstructor()
		                      ->getMock();

		$route->expects( $this->once() )
		      ->method( 'error' )
		      ->with( $response, 'Required parameter missing: zip' )
		      ->willReturn( $routeResponse );

		$this->assertEquals( $routeResponse, $subject->callback( $request, $response ) );
	}
}