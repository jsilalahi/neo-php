<?php

use PHPUnit\Framework\TestCase;
use DynEd\Neo\Token\TokenRequestApi;

class TokenRequestApiTest extends TestCase
{
    // NOTE: due this library is public and should be use internal only,
    // the data below should be removed before pushed to GitHub.
    protected $baseUri = "http://host.test";
    protected $username = "username";
    protected $password = "password";

    public function testTokenRequestApiWithoutCredential()
    {
        $tokenRequestApi = (new TokenRequestApi())
            ->setBaseUri($this->baseUri);

        $this->expectException(
            "DynEd\Neo\Exceptions\ValidationException"
        );

        $tokenRequestApi->request();
    }

    public function testTokenRequestApiWithCredential()
    {
        $tokenRequestApi = (new TokenRequestApi())
            ->setBaseUri($this->baseUri)
            ->setCredential([
                'username' => $this->username,
                'password' => $this->password
            ]);

        $token = $tokenRequestApi->request();

        $this->assertInstanceOf("\DynEd\Neo\Token\TokenResource", $token);
        $this->assertIsString($token->getToken());
    }

}


