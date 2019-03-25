<?php

namespace DynEd\Neo\Token;

use DynEd\Neo\Api\AbstractApi;
use DynEd\Neo\Exceptions\ValidationException;

class TokenVerify extends AbstractApi
{
    /** @var string */
    const ENDPOINT = "/token-verify";

    /** @var Token */
    protected $token;

    /**
     * Set token to verify
     *
     * @param Token $token
     * @return $this
     */
    public function setToken(Token $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Verify token
     *
     * @return bool
     * @throws ValidationException
     */
    public function verify()
    {
        // Token validation
        if( ! $this->token || ! ($this->token instanceof Token)) {
            throw new ValidationException("Given token is not valid");
        }

        // Verify
        $response = $this->httpClient->post(
            sprintf('%s/%s', $this->baseUri,self::ENDPOINT),
            [
                'json' => [
                    'token' => $this->token->getToken(),
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