# PHP Library for Neo API Ecosystem 
[![Build Status](https://travis-ci.org/jsilalahi/neo-php.svg?branch=master)](https://travis-ci.org/jsilalahi/neo-php)

NOTE: neo-php still on heavy development. Do not use on production yet.

##### Installation

The easiest way to install neo-php library is using composer
```
composer require dyned/neo-php
```
That's it!


##### Test
Run the PHPUnit test using PHPUnit.
```
./vendor/bin/phpunit --bootstrap vendor/autoload.php tests --do-not-cache-result
```
Since the test reads several environment variable, such as service configuration, you need to provide: `NEO_SSO_BASE_URI`, `NEO_SSO_USERNAME`, `NEO_SSO_PASSWORD`. In your macOS, you can use export command
```
export NEO_SSO_BASE_URI="https://domain.com"
export NEO_SSO_USERNAME="username"
export NEO_SSO_PASSWORD="password"
```