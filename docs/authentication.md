# Authentication
Authentication module is implementation and API wrapper for SSO service.

##### Setup
First thing before using `Auth` module, you need to setup service HTTP Client. Neo PHP ships `GuzzleHttpClient` as default HTTP Client using GuzzleHttp implementation. In case of Auth module used before HTTP Client set up, an configuration exception (`DynEd\Neo\Exceptions\ConfigurationException`) will thrown.

```php
<?php 

require "vendor/autoload.php";

use DynEd\Neo\Auth\Auth;
use DynEd\Neo\HttpClients\GuzzleHttpClient;

// Setup HTTP client
$httpClient = new GuzzleHttpClient([
    'base_uri' => "https://domain.com"
]);

// Setup Auth using GuzzleHttpClient implementation
$auth = new Auth($httpClient);

// Now, you can use $auth
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
Token retrieves JSON Web Token (JWT) from SSO service based on given credential. This method accept credential in array and consist of `username` and `password` keys. In case of credential is missing, an validation exception (`DynEd\Neo\Exceptions\ValidationException`) thrown. This method return Token (`DynEd\Neo\Auth\Token`) type.

```php
<?php

use DynEd\Neo\Auth\Auth;
use DynEd\Neo\HttpClients\GuzzleHttpClient;

// Setup HTTP client
$httpClient = new GuzzleHttpClient([
    'base_uri' => "https://domain.com"
]);

// Setup Auth using GuzzleHttpClient implementation
$auth = new Auth($httpClient);

$token = $auth->token([
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
Sometimes, you want to verify existing token to SSO service. To do that you may call `verify` method and pass the token (`DynEd\Neo\Auth\Token`) to verify. The method will return boolean whether token is valid or not.

```php
<?php

use DynEd\Neo\Auth\Auth;

// Setup Auth HttpClient and retrieve token from any source

$valid = $auth->verify($token);
echo ($valid) ? "Valid" : "Invalid";
```

##### User
If you have token (`DynEd\Neo\Auth\Token`) and want to retrieve the user ACL and profile information, you may using `user` method. This method accept token (`DynEd\Neo\Auth\Token`) and will return user's ACL and profile.

 ```php
<?php

use DynEd\Neo\Auth\Auth;

// Setup Auth HttpClient and retrieve token from any source

$user = $auth->user($token);
var_dump($user->acl);
var_dump($user->profile);
```

 
##### Login
A bit different with others method, `login` return User (`DynEd\Neo\Auth\User`) by passing credential. This method return user with more information such as token (`DynEd\Neo\Auth\Token`), ACL and profile.

 ```php
<?php

use DynEd\Neo\Auth\Auth;

// Setup Auth HttpClient and retrieve token

$user = $auth->login([
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
 
### Feature Request
If you have any feature request to Auth module, feel free to open issue in this GitHub projects.
