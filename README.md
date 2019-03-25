# PHP Library for Neo API Ecosystem

NOTE: neo-php still on heavy development. Do not use on production yet.

## Installation

The easiest way to install neo-php library is using composer
```
composer require dyned/neo-php
```
That's it!

## Token API

##### Token Request API

Below are example to using Token Request API.

```php
<?php

// Require autoload
require "vendor/autoload.php";

use DynEd\Neo\Token\TokenRequest;

// Using TokenRequest instance
$api = new TokenRequest();
$api->setBaseUri("http://host.test/endpoint")
    ->setCredential([
        'username' => 'username',
        'password' => 'password'
    ]);
                
$token = $api->request();

// Or using method chain
$token = (new TokenRequest())
         ->setBaseUri("http://host.test/endpoint")
         ->setCredential([
             'username' => 'username',
             'password' => 'password'
         ])
         ->request();
         
// Use the token
echo $token->getToken();
```

##### Token Verify API
The token to verify should be an `DynEd\Neo\Token\Token` instance. The token can be retrieved from Token Request API, 
or if you only has the token in string, you can wrap to Token instance

Below are example to using Token Verify API.

```php
<?php

// Require autoload
require "vendor/autoload.php";

use DynEd\Neo\Token\TokenRequest;
use DynEd\Neo\Token\TokenVerify;
use DynEd\Neo\Token\Token;

// Retrieved from TokenRequest
$token = (new TokenRequest())
         ->setBaseUri("http://host.test/endpoint")
         ->setCredential([
             'username' => 'username',
             'password' => 'password'
         ])
         ->request();

// Or wrap to Token
$token = new Token("xxx");

// Then verify the token
$isVerified = (new TokenVerify())
            ->setBaseUri($this->baseUri)
            ->setToken($token)
            ->verify();
```


## HTTP Client
Neo PHP provides two HTTP Client out of the box, GuzzleHttp (`DynEd\Neo\Api\HttpClient\GuzzleHttpClient`) and cURL (`DynEd\Neo\Api\HttpClient\CurlHttpClient`) HttpClient.

##### Using HTTP Client
By default, if you are not states which HTTP Client to use in API, the library will using `GuzzleHttpClient`. To use specific client, passing the HttpClient in API instance.
```php
<?php

use DynEd\Neo\Token\TokenRequest;
use DynEd\Neo\Api\HttpClient\CurlHttpClient;

// Using default HttpClient, GuzzleHttpClient
$api = new TokenRequest();

// Using CurlHttpClient
$api = new TokenRequest(new CurlHttpClient);
```

##### Custom HTTP Client
If you prefer to using your own HTTP Client, you need to implement the `DynEd\Neo\Api\HttpClientInterface` and write code for the `get`, `post`, `put`, `patch`, and `delete` method. 
So the new HTTP Client would look something like this:

```php
<?php

use DynEd\Neo\Api\HttpClientInterface;

class CustomHttpClient implements HttpClientInterface
{  
        public function get($uri, array $options = []) { /* Implement */ }
        public function post($uri, array $options = [])  { /* Implement */ }
        public function put($uri, array $options = [])  { /* Implement */ }
        public function patch($uri, array $options = [])  { /* Implement */ }
        public function delete($uri)  { /* Implement */ }
}
```


## Tests
`./vendor/bin/phpunit --bootstrap vendor/autoload.php tests --do-not-cache-result ` 


