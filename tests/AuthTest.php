<?php

use PHPUnit\Framework\TestCase;
use DynEd\Neo\Auth\Auth;
use DynEd\Neo\HttpClients\GuzzleHttpClient;
use DynEd\Neo\Exceptions\ValidationException;
use DynEd\Neo\Auth\Token;
use Tightenco\Collect\Support\Collection;

class AuthTest extends TestCase
{
    protected $baseUri;
    protected $username;
    protected $password;
    protected $auth;

    public function setUp(): void
    {
        parent::setUp();

        $this->baseUri = getenv("NEO_SSO_BASE_URI");
        $this->username = getenv("NEO_SSO_USERNAME");
        $this->password = getenv("NEO_SSO_PASSWORD");

        $httpClient = new GuzzleHttpClient([
            'base_uri' => getenv("NEO_SSO_BASE_URI")
        ]);

        $this->auth = new Auth($httpClient);
    }

    public function testAuthTokenValidation_EmptyCredential()
    {
        $this->expectException(
            ValidationException::class
        );

        $this->auth->token([]);
    }

    public function testAuthTokenValidation_InvalidUsername()
    {
        $token = $this->auth->token([
            'username' => 'invalid',
            'password' => $this->password
        ]);

        $this->assertNull($token);
    }

    public function testAuthTokenValidation_PasswordNotMatch()
    {
        $token = $this->auth->token([
            'username' => $this->username,
            'password' => 'invalid'
        ]);

        $this->assertNull($token);
    }

    public function testAuthTokenCredential()
    {
        $token = $this->auth->token([
            'username' => $this->username,
            'password' => $this->password
        ]);

        $this->assertInstanceOf(Token::class, $token);
        $this->assertIsString($token->string());
    }

    public function testAuthTokenCredential_RawResponse()
    {
        $this->auth->setConfig('raw_response', false);

        $this->assertEquals(false, $this->auth->getConfig('raw_response'));

        $token = $this->auth->token([
            'username' => $this->username,
            'password' => $this->password
        ]);

        $this->assertInstanceOf(Token::class, $token);
        $this->assertIsString($token->string());

        $this->auth->setConfig('raw_response', true);

        $this->assertEquals(true, $this->auth->getConfig('raw_response'));

        $token = $this->auth->token([
            'username' => $this->username,
            'password' => $this->password
        ]);

        $this->assertIsString($token);

        $this->auth->setConfig(['raw_response' => false]);

        $this->assertEquals(false, $this->auth->getConfig('raw_response'));
    }



    public function testAuthTokenVerify_Invalid()
    {
        $valid = $this->auth->verify(
            new Token('invalid')
        );

        $this->assertFalse($valid);
    }

    public function testAuthTokenVerify_Valid()
    {
        $token = $this->auth->token([
            'username' => $this->username,
            'password' => $this->password
        ]);

        $valid = $this->auth->verify($token);

        $this->assertTrue($valid);
    }

    public function testAuthUser()
    {
        $token = $this->auth->token([
            'username' => $this->username,
            'password' => $this->password
        ]);

        $user = $this->auth->user($token);

        $this->assertObjectHasAttribute("acl", $user);
        $this->assertObjectHasAttribute("profile", $user);
    }

    public function testAuthLogin()
    {
        $user = $this->auth->login([
            'username' => $this->username,
            'password' => $this->password
        ]);

        $this->assertTrue($this->auth->verify($user->token()));
        $this->assertInstanceOf(Token::class, $user->token());
        $this->assertInstanceOf(Collection::class, $user->acl());
        $this->assertInstanceOf(Collection::class, $user->profile());
        $this->assertEquals('super_admin', $user->profile()->get('roles')[0]);
        $this->assertEquals('super_admin', $user->profile("roles")[0]);
    }
}


