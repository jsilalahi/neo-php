<?php

use PHPUnit\Framework\TestCase;
use DynEd\Neo\AccessToken\Api as AccessTokenApi;
use DynEd\Neo\AccessToken\Token;

class AccessTokenApiTest extends TestCase
{
    protected $baseUri = "https://b2ctest.dyned.com/api/v1/jwt";
    protected $username = "tebetutara2";
    protected $password = "!@#DynEd12810*()";

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


