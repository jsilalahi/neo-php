<?php

namespace DynEd\Neo\Auth;

use DynEd\Neo\AbstractApi;
use DynEd\Neo\Exceptions\ConfigurationException;
use DynEd\Neo\Exceptions\ValidationException;

class Auth extends AbstractApi {

    /**
     * Endpoint to request token from SSO service
     *
     * var @string
     */
    const TOKEN_REQUEST_ENDPOINT = "/api/v1/jwt/token-request";

    /**
     * Endpoint to verify token from SSO service
     *
     * var @string
     */
    const TOKEN_VERIFY_ENDPOINT = "/api/v1/jwt/token-verify";

    /**
     * Endpoint to retrieve user ACL and profile from SSO service
     *
     * @var string
     */
    const USER_ENDPOINT = "/api/v1/sso/user/";

    /**
     * Error message when credential is not complete
     *
     * @var string
     */
    private static $errCredential = "missing credential username or password";

    /**
     * Error message when token type is miss match
     *
     * @var string
     */
    private static $errTokenType = "invalid token type";

    /**
     * Retrieve token from SSO service based on given credential
     *
     * @param array $credential
     * @return Token|null
     * @throws ConfigurationException
     * @throws ValidationException
     */
    public static function token(array $credential)
    {
        self::httpClientSetOrFail();

        self::validate($credential, [
            'username' => 'required',
            'password' => 'required',
        ], self::$errCredential);

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

        if ($response->getStatusCode() == '200') {
            return new Token(
                json_decode($response->getBody()->getContents())->token
            );
        }

        return null;
    }

//    /**
//     * Verify given token from SSO service
//     *
//     * @param Token $token
//     * @return bool
//     * @throws ConfigurationException
//     * @throws ValidationException
//     */
//    public static function verify(Token $token)
//    {
//        self::httpClientSetOrFail();
//
//        if( ! ($token instanceof Token)) {
//            throw new ValidationException(self::$errTokenType);
//        }
//
//        $response = self::$httpClient->post(self::TOKEN_VERIFY_ENDPOINT,
//            [
//                'json' => [
//                    'token' => $token->string(),
//                ],
//                'headers' => [
//                    'Content-Type' => 'application/json'
//                ]
//            ]
//        );
//
//        if ($response->getStatusCode() == '200') {
//            return true;
//        }
//
//        return false;
//    }
//
//    /**
//     * Retrieve user info based on given token
//     *
//     * @param Token $token
//     * @return mixed|null
//     * @throws ConfigurationException
//     * @throws ValidationException
//     */
//    public static function user(Token $token)
//    {
//        self::httpClientSetOrFail();
//
//        if(! ($token instanceof Token)) {
//            throw new ValidationException(self::$errTokenType);
//        }
//
//        $response = self::$httpClient->get(self::USER_ENDPOINT . $token->parse()->get('payload')->username,
//            [
//                'headers' => [
//                    'X-Dyned-Tkn' => $token->string(),
//                    'Accept' => 'application/json',
//                ]
//            ]
//        );
//
//        if ($response->getStatusCode() == '200') {
//            return json_decode($response->getBody()->getContents());
//        }
//
//        return null;
//    }
//
//    /**
//     * Login authorize given credential and returns user (with token, acl and profile)
//     *
//     * @param array $credential
//     * @return User
//     * @throws ConfigurationException
//     * @throws ValidationException
//     */
//    public static function login(array $credential)
//    {
//        self::httpClientSetOrFail();
//
//        self::validate($credential, [
//            'username' => 'required',
//            'password' => 'required',
//        ], self::$errCredential);
//
//        $token = self::token($credential);
//        $user = self::user($token);
//
//        return User::create([
//            'token' => $token,
//            'acl' => $user->acl,
//            'profile' => $user->profile
//        ]);
//    }


}