# Study
Study module is implementation and API wrapper for NSA service.

#### Setup
You may need to setup HTTP client before using Study module. Please refer to [authentication documentation](authentication.md) how to setup a HTTP client. 

#### Students of Organisation
Use this method to retrieve students of organisation from NSA. This method accept organisation's UIC (Universal Identifier Code) and pagination number (by default, the page is 1). Please keep in mind that this method require an admin. You can retrieve admin token from Auth module. 

```php
<?php

use DynEd\Neo\Auth\Token;
use DynEd\Neo\Study\Student;
use DynEd\Neo\HttpClients\GuzzleHttpClient;

// Setup HTTP client
$httpClient = new GuzzleHttpClient([
    'base_uri' => "https://domain.com"
]);

// Setup Study using GuzzleHttpClient implementation
$nsa = new Student($httpClient);

// Specified which page you need to fetch. By default it's 1.
$page = 1; 

// Admin token. You may retrieve this from Auth module
$adminToken = $auth->token([
    'username' => 'admin',
    'password' => 'admin'
]);

$students= $nsa->useAdminToken($adminToken)->organisation('001', $page);
```

##### Student Study Summary
Use this method to retrieve student's summary of study. This method accept student's SSO username (usually an email address) and an array of selected period (in date, yyyy-mm-dd format). Please keep in mind that this method require an admin. You can retrieve admin token from Auth module. 

```php
<?php

use DynEd\Neo\Auth\Token;
use DynEd\Neo\Study\Student;
use DynEd\Neo\HttpClients\GuzzleHttpClient;

// Setup HTTP client
$httpClient = new GuzzleHttpClient([
    'base_uri' => "https://domain.com"
]);

// Setup Study using GuzzleHttpClient implementation
$nsa = new Student($httpClient);

$student = 'jsilalahi@dyned.com'; // Student's SSO username
$period = ['start' => '2018-01-01', 'end' => '2020-01-01'];
$adminToken = new Token('xxx'); // You may retrieve this from Auth

$sr = $nsa->useAdminToken($adminToken)->summary($student, $period);
```

### Notes
This module is not complete. Some method may come in future.
