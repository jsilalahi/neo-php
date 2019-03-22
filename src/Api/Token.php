<?php

namespace DynEd\Neo\Api;

use DynEd\Neo\Exceptions\ValidationException;
use Rakit\Validation\Validator;

class Token extends AbstractApi
{
    /** @var string */
    const ENDPOINT_TOKEN_REQUEST = "/token-request";

    /** @var string */
    const ENDPOINT_TOKEN_VERIFY = "/token-verify";


    /**
     * Handle API request
     *
     * @param array $credential
     * @return mixed|null
     * @throws ValidationException
     */
    public function request(array $credential)
    {
        // Credential validation
        $validation = (new Validator)->validate($credential, [
            'username' => 'required',
            'password' => 'required',
        ]);

        // If the credential validation do not pass, then an exception will be thrown
        if ($validation->fails()) {
            throw new ValidationException("Given credential data does not pass validation");
        }

        // Send request
        $response = $this->httpClient->post(
            sprintf('%s/%s', $this->baseUri,self::ENDPOINT_TOKEN_REQUEST),
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
}