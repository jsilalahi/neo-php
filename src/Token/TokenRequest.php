<?php

namespace DynEd\Neo\Token;

use DynEd\Neo\Api\AbstractApi;
use DynEd\Neo\Exceptions\ValidationException;
use Rakit\Validation\Validator;

class TokenRequest extends AbstractApi
{
    /** @var string */
    const ENDPOINT = "/token-request";

    /** @var array */
    protected $credential = [];

    /**
     * Set credential of token to request
     *
     * @param array $credential
     * @return $this
     */
    public function setCredential(array $credential)
    {
        $this->credential = $credential;

        return $this;
    }

    /**
     * Request token API request
     *
     * @return mixed|null
     * @throws ValidationException
     */
    public function request()
    {
        // Credential validation
        $validation = (new Validator)->validate($this->credential, [
            'username' => 'required',
            'password' => 'required',
        ]);

        // If the credential validation do not pass, then an exception will be thrown
        if ($validation->fails()) {
            throw new ValidationException("Given credential data does not pass validation");
        }

        // Send request
        $response = $this->httpClient->post(
            sprintf('%s/%s', $this->baseUri,self::ENDPOINT),
            [
                'json' => [
                    'username' => $this->credential['username'],
                    'password' => $this->credential['password']
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