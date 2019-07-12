<?php

use DynEd\Neo\Auth\Auth;
use DynEd\Neo\HttpClients\GuzzleHttpClient;
use PHPUnit\Framework\TestCase;
use DynEd\Neo\Etest\Bank;
use Tightenco\Collect\Support\Collection;

class EtestBankTest extends TestCase
{
    protected $username;
    protected $password;
    protected $bank;
    protected $auth;

    public function setUp(): void
    {
        parent::setUp();

        $this->username = getenv("NEO_SSO_USERNAME");
        $this->password = getenv("NEO_SSO_PASSWORD");

        $this->bank = new Bank(new GuzzleHttpClient([
            'base_uri' => getenv("NEO_ETEST_BASE_URI"),
            'timeout' => 120
        ]));
        $this->auth = new Auth(new GuzzleHttpClient([
            'base_uri' => getenv("NEO_SSO_BASE_URI")
        ]));

        $token = $this->auth->token([
            'username' => $this->username,
            'password' => $this->password
        ]);

        $this->bank->useAdminToken($token);
    }

    public function testQuestions()
    {
        $questions = $this->bank->questions();

        $this->assertNotNull($questions);
        $this->assertInstanceOf(Collection::class, $questions);
    }
}


