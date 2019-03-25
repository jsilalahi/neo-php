<?php

use PHPUnit\Framework\TestCase;
use DynEd\Neo\Token\TokenRequest;
use DynEd\Neo\Token\TokenVerify;
use DynEd\Neo\Token\Token;

class TokenVerifyTest extends TestCase
{
    protected $baseUri = "http://host.test/endpoint";
    protected $username = "username";
    protected $password = "password";

    public function testTokenVerifyInvalid()
    {
        $isVerified = (new TokenVerify())
            ->setBaseUri($this->baseUri)
            ->setToken(new Token("invalid"))
            ->verify();

        $this->assertEquals(false, $isVerified);
    }

    public function testTokenVerifyValid()
    {
        $token = (new TokenRequest())
            ->setBaseUri($this->baseUri)
            ->setCredential([
                'username' => $this->username,
                'password' => $this->password
            ])
            ->request();

        $isVerified = (new TokenVerify())
            ->setBaseUri($this->baseUri)
            ->setToken($token)
            ->verify();

        $this->assertEquals(true, $isVerified);
    }
}


