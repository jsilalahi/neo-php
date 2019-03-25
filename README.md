# PHP Library for Neo API Ecosystem

NOTE: Still on heavy development. Do not use on production yet.

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
require "/vendor/autoload.php";

use DynEd\Neo\Token\TokenRequestApi;

// Using TokenRequestApi instance
$api = new TokenRequestApi();
$api->setBaseUri("http://host.test/endpoint")
    ->setCredential([
        'username' => 'username',
        'password' => 'password'
    ]);
                
$token = $api->request();



// Or using method chain
$token = (new TokenRequestApi())
         ->setBaseUri("http://host.test/endpoint")
         ->setCredential([
             'username' => 'username',
             'password' => 'password'
         ])
         ->request();
         
// Use the token
echo $token->getToken();
```


## HTTP Client
Neo PHP provides two HTTP Client out of the box GuzzleHttp (`DynEd\Neo\Api\HttpClient\GuzzleHttpClient`) and cURL (`DynEd\Neo\Api\HttpClient\CurlHttpClient`) Client.

##### Using HTTP Client
By default, if you are not stating which HTTP Client to use in API, neo-php will using `GuzzleHttpClient`. To use specific client, passing the HttpClient in API instance.
```php
<?php

use DynEd\Neo\Token\TokenRequestApi;
use \DynEd\Neo\Api\HttpClient\CurlHttpClient;

// Using default HttpClient, GuzzleHttpClient
$api = new TokenRequestApi();

// Using CurlHttpClient
$api = new TokenRequestApi(new CurlHttpClient);
```

##### Custom HTTP Client
If you prefer to using your own HTTP Client, you need to implement the `DynEd\Neo\Api\HttpClientInterface` and write code for the `get`, `post`, `put`, `patch`, and `delete` method. 
So the new HTTP Client would look something like this:

```php
<?php

use DynEd\Neo\Api\HttpClientInterface;

class CustomHttpClient implements HttpClientInterface
{  
        public function get($uri, array $options = []) { /** Implement */ }
        public function post($uri, array $options = [])  { /** Implement */ }
        public function put($uri, array $options = [])  { /** Implement */ }
        public function patch($uri, array $options = [])  { /** Implement */ }
        public function delete($uri)  { /** Implement */ }
}
```


## Tests
`./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/TokenTest --do-not-cache-result` 


