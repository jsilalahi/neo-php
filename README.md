# PHP Library for Neo API Ecosystem

NOTE: neo-php still on heavy development. Do not use on production yet.

## Installation

The easiest way to install neo-php library is using composer
```
composer require dyned/neo-php
```
That's it!

## Token API

### Token Request API
Below are example using Token Request API.

```php
<?php 
require "vendor/autoload.php";

use Dyned\Neo\AccessToken\Verify;

$verify = new Verify('http://endpoint/SSO_ENDPOINT.test');
$response = $verify->login([
    'username' => 'email@gmail.com',
    'password' => 'secret',
]);
var_dump($response);
```

the `login` method return an array if the status code is 200 / validation correct
```php
    [
        "username" => "string"
        "password" => "string"
        "dyned-token" => "string"
        "user" => "object"
    ]
```
otherwise the response from login method will be null if failed.

If you want to get the `dyned-token` simply use `$response['dyned-token']` to get the access token.


### Custom HTTP Client
If you prefer to using your own HTTP Client, you need to implement the `DynEd\Neo\Api\HttpClientInterface` and write code for the `get`, `post`, `put`, `patch`, and `delete` method. 
So the new HTTP Client would look something like this:

```php
<?php

use DynEd\Neo\HttpClients\HttpClientInterface;

class CustomHttpClient implements HttpClientInterface
{  
        public function get($uri, array $options = []) { /* Implement */ }
        public function post($uri, array $options = [])  { /* Implement */ }
        public function put($uri, array $options = [])  { /* Implement */ }
        public function patch($uri, array $options = [])  { /* Implement */ }
        public function delete($uri)  { /* Implement */ }
}
```