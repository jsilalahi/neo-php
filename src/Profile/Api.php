<?php

namespace DynEd\Neo\Profile;

use DynEd\Neo\AbstractApi;
use DynEd\Neo\AccessToken\Token;
use DynEd\Neo\Exceptions\ValidationException;

class Api extends AbstractApi {

    /** @var string */
    const PROFILE_ENDPOINT = "sso/user/";

    /**
     *
     *
     * @param Token $token
     * @return Token|null
     * @throws ValidationException
     */
    public function profile(Token $token)
    {
        // Token validation
        if(! ($token instanceof Token)) {
            throw new ValidationException("invalid token");
        }

        $body = $this->parse($token);

        // Send request
        $response = $this->httpClient->get(
            sprintf('%s/%s', $this->baseUrl,self::PROFILE_ENDPOINT . $body['payload']->username),
            [
                'headers' => [
                    'X-Dyned-Tkn' => $token->getToken(),
                    'Accept' => 'application/json',
                ]
            ]
        );

        if ($response->getStatusCode() == '200') {
            return json_decode($response->getBody()->getContents());
        }

        return null;
    }

    /**
     * Parse JWT into readable header and payload
     *
     * @param $token
     * @return array
     */
    private function parse(Token $token)
    {
        list($header, $payload, $signature) = explode('.', $token);

        return [
            'header' => json_decode(base64_decode($header)),
            'payload' => json_decode(base64_decode($payload)),
            'signature' => $signature
        ];
    }
}