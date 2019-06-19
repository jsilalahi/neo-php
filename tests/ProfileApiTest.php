<?php

use PHPUnit\Framework\TestCase;
use DynEd\Neo\AccessToken\Api as AccessTokenApi;
use DynEd\Neo\Profile\Api as ProfileApi;

class ProfileApiTest extends TestCase
{
    protected $baseUri = "https://b2ctest.id.dyned.com/api/v1/";
    protected $username = "tebetutara2";
    protected $password = "!@#DynEd12810*()";


    public function testTokenProfile()
    {
        $token = (new AccessTokenApi($this->baseUri . 'jwt/'))
            ->login([
                'username' => $this->username,
                'password' => $this->password
            ]);

        $profile = (new ProfileApi($this->baseUri))
            ->profile($token);

        $this->assertNotNull($profile);
    }
}


