# PHP Library for Neo API Ecosystem

NOTE: Still on heavy development. Do not use on production yet.

## Installation

The easiest way to install is using composer
```
composer require dyned/neo-php

```
That's it!

## Token Request API

Below are example to using Token Request.
```php
// Require autoload
require "vendor/autoload.php";

use DynEd\Neo\Token\TokenRequestApi;

// Using TokenRequestApi instance
$api = new TokenRequestApi();
$api->setBaseUri("http://host.test/endpoint")
    ->setCredential([
        'username' => $username,
        'password' => $password
    ]);
                
$token = $api->request();



// Or using method chain
$token = (new TokenRequestApi())
         ->setBaseUri("http://host.test/endpoint")
         ->setCredential([
             'username' => $username,
             'password' => $password
         ])
         ->request();
         
// Use the token
echo $token->getToken();
```




## Tests
`./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/TokenTest --do-not-cache-result` 


