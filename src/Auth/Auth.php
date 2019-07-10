<?php

namespace DynEd\Neo\Auth;

use DynEd\Neo\AbstractApi;
use DynEd\Neo\Exceptions\ConfigurationException;
use DynEd\Neo\Exceptions\ValidationException;
use Rakit\Validation\Validator;

class Auth extends AbstractApi
{
    /**
     * @inheritDoc
     */
    protected function configure()
    {
        parent::configure();

        $this->endpoints = [
            'token' => '/api/v1/jwt/token-request',
            'verify' => '/api/v1/jwt/token-verify',
            'user' => '/api/v1/sso/user/'
        ];
    }

    /**
     * Retrieve token from SSO service based on given credential
     *
     * @param array $credential
     * @return Token|null
     * @throws ConfigurationException
     * @throws ValidationException
     */
    public function token(array $credential)
    {
        $this->httpClientSetOrFail();

        $validation = (new Validator)->validate($credential, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validation->fails()) {
            throw new ValidationException("missing credential username or password");
        }

        $response = $this->httpClient->post($this->getEndpoints('token'),
            [
                'json' => [
                    'username' => $credential['username'],
                    'password' => $credential['password']
                ],
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]
        );

        if ($response->getStatusCode() != '200') {
            return null;
        }

        $raw = $response->getBody()->getContents();

        if($this->getConfig('raw_response')) {
            return $raw;
        }

        return new Token(
            json_decode($raw)->token
        );
    }

    /**
     * Verify given token from SSO service
     *
     * @param Token $token
     * @return bool
     * @throws ConfigurationException
     * @throws ValidationException
     */
    public function verify(Token $token)
    {
        $this->httpClientSetOrFail();

        if( ! ($token instanceof Token)) {
            throw new ValidationException("invalid token type");
        }

        $response = $this->httpClient->post($this->getEndpoints('verify'),
            [
                'json' => [
                    'token' => $token->string(),
                ],
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]
        );

        if ($response->getStatusCode() == '200') {
            return true;
        }

        return false;
    }

    /**
     * Retrieve user info based on given token
     *
     * @param Token $token
     * @return mixed|null
     * @throws ConfigurationException
     * @throws ValidationException
     */
    public function user(Token $token)
    {
        $this->httpClientSetOrFail();

        if(! ($token instanceof Token)) {
            throw new ValidationException("invalid token type");
        }

        $response = $this->httpClient->get($this->getEndpoints('user') . $token->parse()->get('payload')->username,
            [
                'headers' => [
                    'X-Dyned-Tkn' => $token->string(),
                    'Accept' => 'application/json',
                ]
            ]
        );

        if ($response->getStatusCode() != '200') {
            return null;
        }

        $raw = $response->getBody()->getContents();

        if($this->getConfig('raw_response')) {
            return $raw;
        }

        return json_decode($raw);
    }

    /**
     * Login authorize given credential and returns user (with token, acl and profile)
     *
     * @param array $credential
     * @return User
     * @throws ConfigurationException
     * @throws ValidationException
     */
    public function login(array $credential)
    {
        $this->httpClientSetOrFail();

        $validation = (new Validator)->validate($credential, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validation->fails()) {
            throw new ValidationException("missing credential username or password");
        }

        $token = $this->token($credential);
        $user = $this->user($token);

        return User::create([
            'token' => $token,
            'acl' => $user->acl,
            'profile' => $user->profile
        ]);
    }


}