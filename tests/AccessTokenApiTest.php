<?php

use PHPUnit\Framework\TestCase;
use DynEd\Neo\AccessToken\Api as AccessTokenApi;
use DynEd\Neo\AccessToken\Token;

class AccessTokenApiTest extends TestCase
{
    protected $baseUri = "http://host.test/endpoint";
    protected $username = "username";
    protected $password = "password";

    public function testLoginWithoutCredential()
    {
        $this->expectException(
            "DynEd\Neo\Exceptions\ValidationException"
        );

        (new AccessTokenApi($this->baseUri))
            ->login();
    }

    public function testLoginInvalidCredential()
    {
        $token = (new AccessTokenApi($this->baseUri))
            ->login([
                'username' => $this->username,
                'password' => 'invalid'
            ]);

        $this->assertNull($token);
    }

    public function testLoginValidCredential()
    {
        $token = (new AccessTokenApi($this->baseUri))
            ->login([
                'username' => $this->username,
                'password' => $this->password
            ]);

        $this->assertInstanceOf("\DynEd\Neo\AccessToken\Token", $token);
        $this->assertIsString($token->getToken());
    }

    public function testTokenVerifyInvalid()
    {
        $verified = (new AccessTokenApi($this->baseUri))
            ->verify(new Token("invalid"));

        $this->assertEquals(false, $verified);
    }

    public function testTokenVerifyValid()
    {
        $api = (new AccessTokenApi($this->baseUri));

        $token = $api->login([
                'username' => $this->username,
                'password' => $this->password
            ]);

        $verified = $api->verify($token);

        $this->assertEquals(true, $verified);
    }

}


