# Study
This module is implementation and wrapper library for NSA.

##### Setup
You may need to setup HTTP client before using Study module. Please refer to [authentication documentation](authentication.md) how to setup a client. 

##### Retrieve students from an organisation
To retrieve students of organisation from NSA, admin token is required. You can retrieve admin token from Auth. This method accept organisation's UIC (Universal Identifier Code) and pagination number.

```php
<?php

use DynEd\Neo\Study\Student;
use DynEd\Neo\HttpClients\GuzzleHttpClient;
use DynEd\Neo\Auth\Token;

// Setup HTTP client
$httpClient = new GuzzleHttpClient([
    'base_uri' => "https://domain.com"
]);

// Setup Study using GuzzleHttpClient implementation
$nsa = new Student($httpClient);

$page = 1; // Specified which page you need to fetch. By default its 1.
$adminToken = new Token('xxx'); // You may retrieve this from Auth

$students= $nsa->useAdminToken($adminToken)->organisation('001', $page);
```

##### Retrieve student's summary of study
To retrieve student's summary of study, admin token is required. You can retrieve admin token from Auth. This method accept student's SSO username (usually an email address) and array of selected period (in date, yyyy-mm-dd format).

```php
<?php

use DynEd\Neo\Study\Student;
use DynEd\Neo\HttpClients\GuzzleHttpClient;
use DynEd\Neo\Auth\Token;

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