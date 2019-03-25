<?php

use PHPUnit\Framework\TestCase;
use DynEd\Neo\Token\TokenRequest;

class TokenRequestTest extends TestCase
{
    protected $baseUri = "http://host.test/endpoint";
    protected $username = "username";
    protected $password = "password";

    public function testTokenRequestApiWithoutCredential()
    {
        $this->expectException(
            "DynEd\Neo\Exceptions\ValidationException"
        );

        $api = (new TokenRequest())
            ->setBaseUri($this->baseUri)
            ->request();
    }

    public function testTokenRequestApiWithCredential()
    {
        $token = (new TokenRequest())
            ->setBaseUri($this->baseUri)
            ->setCredential([
                'username' => $this->username,
                'password' => $this->password
            ])
            ->request();

        $this->assertInstanceOf("\DynEd\Neo\Token\Token", $token);
        $this->assertIsString($token->getToken());
    }

}


