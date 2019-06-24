<?php

use PHPUnit\Framework\TestCase;
use DynEd\Neo\Auth\Auth;
use DynEd\Neo\Exceptions\ConfigurationException;
use DynEd\Neo\Auth\Token;

class AuthHttpClientTest extends TestCase
{
    protected $ssoBaseUri;
    protected $ssoUsername;
    protected $ssoPassword;

    public function setUp(): void
    {
        parent::setUp();

        $this->ssoUsername = getenv("NEO_SSO_USERNAME");
        $this->ssoPassword = getenv("NEO_SSO_PASSWORD");
    }

    public function testAuthHttpClient_Token()
    {
        $this->expectException(
            ConfigurationException::class
        );

        Auth::token([
            'username' => $this->ssoUsername,
            'password' => $this->ssoPassword
        ]);
    }

    public function testAuthHttpClient_Verify()
    {
        $this->expectException(
            ConfigurationException::class
        );

        Auth::verify(new Token('invalid_token'));
    }
}


