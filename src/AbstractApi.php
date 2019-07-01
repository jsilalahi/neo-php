<?php

namespace DynEd\Neo;

use DynEd\Neo\Exceptions\ConfigurationException;
use DynEd\Neo\Exceptions\ValidationException;
use DynEd\Neo\HttpClients\HttpClientInterface;
use Rakit\Validation\Validator;

abstract class AbstractApi
{
    /**
     * HTTP client
     *
     * @var HttpClientInterface
     */
    protected static $httpClient;

    /**
     * Error message when HTTP client not setup yet
     *
     * @var string
     */
    protected static $errHttpClient = "setup http client";

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
     * Check if HttpClient is set
     *
     * @return bool
     */
    protected static function isHttpClientSet()
    {
        return (self::$httpClient) ? true : false;
    }

    /**
     * Check if HttpClient is set or throw exception
     *
     * @throws ConfigurationException
     */
    protected static function httpClientSetOrFail()
    {
        if( ! self::isHttpClientSet()) {
            throw new ConfigurationException(self::$errHttpClient);
        }
    }

    /**
     * Validation
     *
     * @param $input mixed
     * @param $rules array
     * @param string $message string
     * @throws ValidationException
     */
    protected static function validate($input, $rules, $message = "input does not pass validation")
    {
        $validation = (new Validator)->validate($input, $rules);

        if ($validation->fails()) {
            throw new ValidationException($message);
        }
    }
}