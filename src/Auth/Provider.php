<?php

namespace DynEd\Neo\Auth;

use DynEd\Neo\AbstractApi;
use DynEd\Neo\Exceptions\ValidationException;
use Rakit\Validation\Validator;

class Provider extends AbstractApi {

    /** @var string */
    const AUTH_ENDPOINT = "token-request";
    const VERIFY_ENDPOINT = "token-verify";

    /**
     * Request access token
     *
     * @param array $credential
     * @return mixed|null
     * @throws ValidationException
     */
    public function login(array $credential = [])
    {
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
        $response = $this->httpClient->post(
            sprintf('%s/%s', $this->baseUrl,self::AUTH_ENDPOINT),
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

    /**
     * Verify access token
     *
     * @param $token
     * @return bool
     * @throws ValidationException
     */
    public function verify(Token $token)
    {
        // Token validation
        if(! ($token instanceof Token)) {
            throw new ValidationException("invalid token");
        }

        // Verify
        $response = $this->httpClient->post(
            sprintf('%s/%s', $this->baseUrl,self::VERIFY_ENDPOINT),
            [
                'json' => [
                    'token' => $token->getToken(),
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