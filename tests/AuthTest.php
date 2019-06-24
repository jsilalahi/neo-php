<?php

use PHPUnit\Framework\TestCase;
use DynEd\Neo\Auth\Auth;
use DynEd\Neo\HttpClients\GuzzleHttpClient;
use DynEd\Neo\Exceptions\ValidationException;
use DynEd\Neo\Auth\Token;
use Tightenco\Collect\Support\Collection;

class AuthTest extends TestCase
{
    protected $ssoBaseUri;
    protected $ssoUsername;
    protected $ssoPassword;

    public function setUp(): void
    {
        parent::setUp();

        $this->ssoBaseUri = getenv("NEO_SSO_BASE_URI");
        $this->ssoUsername = getenv("NEO_SSO_USERNAME");
        $this->ssoPassword = getenv("NEO_SSO_PASSWORD");

        Auth::useHttpClient(new GuzzleHttpClient([
            'base_uri' => getenv("NEO_SSO_BASE_URI")
        ]));
    }

    public function testAuthTokenValidation_EmptyCredential()
    {
        $this->expectException(
            ValidationException::class
        );

        Auth::token([]);
    }

    public function testAuthTokenValidation_InvalidUsername()
    {
        $token = Auth::token([
            'username' => 'invalid',
            'password' => $this->ssoPassword
        ]);

        $this->assertNull($token);
    }

    public function testAuthTokenValidation_PasswordNotMatch()
    {
        $token = Auth::token([
            'username' => $this->ssoUsername,
            'password' => 'invalid'
        ]);

        $this->assertNull($token);
    }

    public function testAuthTokenCredential()
    {
        $token = Auth::token([
            'username' => $this->ssoUsername,
            'password' => $this->ssoPassword
        ]);

        $this->assertInstanceOf(Token::class, $token);
        $this->assertIsString($token->string());
    }

    public function testAuthTokenVerify_Invalid()
    {
        $valid = Auth::verify(
            new Token('invalid')
        );

        $this->assertFalse($valid);
    }

    public function testAuthTokenVerify_Valid()
    {
        $token = Auth::token([
            'username' => $this->ssoUsername,
            'password' => $this->ssoPassword
        ]);

        $valid = Auth::verify($token);

        $this->assertTrue($valid);
    }

    public function testAuthUser()
    {
        $token = Auth::token([
            'username' => $this->ssoUsername,
            'password' => $this->ssoPassword
        ]);

        $user = Auth::user($token);

        $this->assertObjectHasAttribute("acl", $user);
        $this->assertObjectHasAttribute("profile", $user);
    }

    public function testAuthLogin()
    {
        $user = Auth::login([
            'username' => $this->ssoUsername,
            'password' => $this->ssoPassword
        ]);

        $this->assertTrue(Auth::verify($user->token()));
        $this->assertInstanceOf(Token::class, $user->token());
        $this->assertInstanceOf(Collection::class, $user->acl());
        $this->assertInstanceOf(Collection::class, $user->profile());
        $this->assertEquals('super_admin', $user->profile()->get('roles')[0]);
        $this->assertEquals('super_admin', $user->profile("roles")[0]);
    }
}


