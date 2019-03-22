


## Token Request

Below are example to using Token Request.
```php
// Require autoload
require "vendor/autoload.php";

use DynEd\Neo\Token\TokenRequestApi;

// Using TokenRequestApi instance
$api = new TokenRequestApi();
$api->setBaseUri("http://dyned.com/base/uri/to/jwt")
    ->setCredential([
        'username' => $this->username,
        'password' => $this->password
    ]);
                
$token = $api->request();



// Or using method chain
$token = (new TokenRequestApi())
         ->setBaseUri("http://dyned.com/base/uri/to/jwt")
         ->setCredential([
             'username' => $this->username,
             'password' => $this->password
         ])
         ->request();
         
// Use the token
echo $token->getToken();
```




## Tests
`./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/TokenTest --do-not-cache-result` 


