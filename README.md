# PHP Library for Neo API Ecosystem 
[![Build Status](https://travis-ci.org/jsilalahi/neo-php.svg?branch=master)](https://travis-ci.org/jsilalahi/neo-php)

NOTE: neo-php still on heavy development. Do not use on production yet.

##### Installation

The easiest way to install neo-php library is using composer
```
composer require dyned/neo-php
```
That's it!


### Authentication


##### Setup
First thing before using `Auth` module, you need to setup HTTP Client implementation. Neo PHP ships `GuzzleHttpClient` as HTTP Client using GuzzleHttp implementation. In case Auth module used before HTTP Client set up, an configuration exception (`DynEd\Neo\Exceptions\ConfigurationException`) thrown.

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

Feel free to using your own HTTP Client implementation as necessary. You may need to implement the `DynEd\Neo\HttpClients\HttpClientInterface` and write code for the `get`, `post`, `put`, `patch`, and `delete` method in your custom implementation. The new custom HTTP Client would look something like this:

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
Token retrieves JWT from SSO service based on given credential. The method accept credential in array consist of `username` and `password`. In case credential is missing, an validation exception (`DynEd\Neo\Exceptions\ValidationException`) thrown. This method return Token (`DynEd\Neo\Auth\Token`).

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
// The returned data is in collection (\Tightenco\Collect\Support\Collection)
// Which is same collection with Laravel using
$parsed = $token->parse();

// Get token username from payload
echo $parsed->get('payload')->username;
```

##### Verify
To verify existing token, you may call verify method and pass the token to verify. The method return boolean whether valid or not.

```php
<?php

use DynEd\Neo\Auth\Auth;

// Setup Auth HttpClient and retrieve token from any source

$valid = Auth::verify($token);
echo ($valid) ? "Valid" : "Invalid";
```

##### User
Retrieve user ACL and profile from existing token.

 ```php
<?php

use DynEd\Neo\Auth\Auth;

// Setup Auth HttpClient and retrieve token from any source

$user = Auth::user($token);
var_dump($user->acl);
var_dump($user->profile);
```

 
##### Login
Login return User (`DynEd\Neo\Auth\User`) by passing credential. The user contain information about token, ACL and profile.

 ```php
<?php

use DynEd\Neo\Auth\Auth;

// Setup Auth HttpClient and retrieve token

$user = Auth::login([
    'username' => 'username',
    'password' => 'password'
]);

// Retrieve user's token
echo $user->token();

// Retrieve user's profile collection
var_dump($user->profile());
echo $user->profile()->get('roles')[0];
echo $user->profile("roles")[0];

// Retrieve user's ACL collection
var_dump($user->acl());
```
 