<?php

namespace Neo\Api;

class Token extends AbstractApi
{
    /** @var string */
    const ENDPOINT_TOKEN_REQUEST = "/token-request";

    /** @var string  */
    const ENDPOINT_TOKEN_VERIFY = "/token-verify";

    /**
     * Retrieve token
     *
     * @param $username
     * @param $password
     * @return mixed|null
     */
    public function retrieve($username, $password)
    {
        $response = $this->httpClient->post(
            sprintf('%s/%s', $this->baseUrl,self::ENDPOINT_TOKEN_REQUEST),
            [
                'json' => [
                    'username' => $username,
                    'password' => $password
                ],
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]
        );

        if ($response->getStatusCode() == '200') {
            return json_decode($response->getBody()->getContents());
        }

        return null;
    }
}