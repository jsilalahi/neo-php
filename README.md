# PHP Library for Neo API Ecosystem 
[![Build Status](https://travis-ci.org/jsilalahi/neo-php.svg?branch=master)](https://travis-ci.org/jsilalahi/neo-php)

NOTE: neo-php still on heavy development. Do not use on production yet.

## Installation

The easiest way to install neo-php library is using composer
```
composer require dyned/neo-php
```
That's it!


### Auth

##### Setup
First thing before using `Auth` module, you need to setup HTTP Client implementation. Neo PHP ships `GuzzleHttpClient` as HTTP Client using GuzzleHttp implementation. In case HTTP Client not set up yet, an configuration exception (`DynEd\Neo\Exceptions\ConfigurationException`) thrown.

```php
<?php 

require "vendor/autoload.php";

use DynEd\Neo\Auth\Auth;
use DynEd\Neo\HttpClients\GuzzleHttpClient;

// Setup Auth using GuzzleHttpClient implementation
Auth::useHttpClient(new GuzzleHttpClient([
    'base_uri' => "https://domain.com"
]));

// Now, you can use Auth
```

Feel free to using your own HTTP Client implementation as necessary. You need to implement the `DynEd\Neo\HttpClients\HttpClientInterface` and write code for the `get`, `post`, `put`, `patch`, and `delete` method implementation. So the new HTTP Client would look something like this:

```php
<?php

use DynEd\Neo\HttpClients\HttpClientInterface;

class CustomHttpClient implements HttpClientInterface {
    public function get($uri, array $options = []) { /* Implement */ }
    public function post($uri, array $options = [])  { /* Implement */ }
    public function put($uri, array $options = [])  { /* Implement */ }
    public function patch($uri, array $options = [])  { /* Implement */ }
    public function delete($uri)  { /* Implement */ }
}
```

##### Token
Token retrieves JWT token from SSO service based on given credential. The method accept credential in array consist of `username` and `password`. In case credential is missing, an validation exception (`DynEd\Neo\Exceptions\ValidationException`) thrown. This method return Token (`DynEd\Neo\Auth\Token`).

```php
<?php

use DynEd\Neo\Auth\Auth;
use DynEd\Neo\HttpClients\GuzzleHttpClient;

// Setup Auth using GuzzleHttpClient implementation
Auth::useHttpClient(new GuzzleHttpClient([
    'base_uri' => "https://domain.com"
]));

$token = Auth::token([
    'username' => 'username',
    'password' => 'password'
]);

// Printing token using magic method __toString or casting method
echo $token;
echo $token->string();

// Retrieve JWT token decoded
// The returned data is collection (\Tightenco\Collect\Support\Collection)
// Which is same collection with Laravel using
$parsed = $token->parse();

// Get token username from payload
echo $parsed->get('payload')->username;
```