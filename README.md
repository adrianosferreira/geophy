

## GeoPhy Gateway API [![Build Status](https://travis-ci.org/adrianosferreira/geophy.svg?branch=master)](https://travis-ci.org/adrianosferreira/geophy)

This is a gateway API very useful in situations where you need to gather data from different endpoints without overloading the Client, which can be a Mobile, a Web app or another API.

The idea is to make a single REST request and let the gateway do the remaining requests and mount the expected response for the Client.

In this case, we are working with Attom's API: https://api.developer.attomdata.com

Please look at the image below:

![alt text](example.png "Gateway API")

Imagine that the Client application needs a list of properties under certain address (zip), sales history information and also schools around. Without the Gateway API, the Client would need to do at least 21 requests.

This pattern would reduce the Client request into a single one and let the gateway (more robust machine) do the rest of the requests and prepare the response.

I didn't want to take this so long, but this could be also a good solution for aggregating other properties from distinct web services.

## Endpoints

There are 2 endpoints in here:

- `/api/v1/auth`: this api uses JSON Web Token Authentication, so you should pass any `username` and `password` and it will generate a token which will let you access the other routes. To access the other routes, you must authenticate by adding a header `X-Token=YOUR_TOKEN`
- `/api/v1/properties`: this returns a list of properties under certain address. It accepts GET method and `zip` parameter, e.g: `/api/v1/properties?zip=80212`

This app is hosted on Heroku, so routes are:

- https://geophy-gateway-api.herokuapp.com/api/v1/auth
- https://geophy-gateway-api.herokuapp.com/api/v1/properties

Request for getting token:

```
curl --header "username: adriano" --header "password: pass" https://geophy-gateway-api.herokuapp.com/api/v1/auth
```

Request for properties:

```
curl --header "X-Token: YOUR_TOKEN_GOES_HERE" https://geophy-gateway-api.herokuapp.com/api/v1/properties?zip=80202
```

## Stack

- Slim
- Slim JWT Auth
- PHP JWT
- PHPUnit
- Mockery
- Guzzle
- Docker
- Composer
- Travis CI