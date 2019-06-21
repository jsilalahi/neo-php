<?php

namespace DynEd\Neo\Auth;

use DynEd\Neo\Exceptions\ConfigurationException;
use DynEd\Neo\Exceptions\ValidationException;
use DynEd\Neo\HttpClients\HttpClientInterface;
use Rakit\Validation\Validator;

class Auth {

    /**
     * SSO token request endpoint
     *
     * var @string
     */
    const TOKEN_REQUEST_ENDPOINT = "/api/v1/jwt/token-request";

    /**
     * SSO token verify endpoint
     *
     * var @string
     */
    const TOKEN_VERIFY_ENDPOINT = "/api/v1/jwt/token-verify";

    /**
     * Auth service provider
     *
     * @var Provider
     */
    private static $httpClient;

    /**
     * Setup
     *
     * @param HttpClientInterface $httpClient
     */
    public static function useHttpClient(HttpClientInterface $httpClient)
    {
        self::$httpClient = $httpClient;
    }

    /**
     * Retrieve token from SSO for given credential
     *
     * @param array $credential
     * @return Token|null
     * @throws ConfigurationException
     * @throws ValidationException
     */
    public static function token(array $credential)
    {
        if( ! self::$httpClient) {
            throw new ConfigurationException("please setup HTTP client first");
        }

        // Credential validation
        $validation = (new Validator)->validate($credential, [
            'username' => 'required',
            'password' => 'required',
        ]);

        // If the credential validation do not pass, then an exception will be thrown
        if ($validation->fails()) {
            throw new ValidationException("missing credential username or password");
        }

        // Send request
        $response = self::$httpClient->post(self::TOKEN_REQUEST_ENDPOINT,
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

        // Check HTTP status code response
        if ($response->getStatusCode() == '200') {
            return new Token(
                json_decode($response->getBody()->getContents())->token
            );
        }

        return null;
    }

    /**
     * Verify whether given token is valid or not
     *
     * @param Token $token
     * @return bool
     * @throws ValidationException
     */
    public static function verify(Token $token)
    {
        // Token validation
        if( ! ($token instanceof Token)) {
            throw new ValidationException("invalid token type");
        }

        // Verify
        $response = self::$httpClient->post(self::TOKEN_VERIFY_ENDPOINT,
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

}