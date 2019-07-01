<?php

namespace DynEd\Neo\Interim;

use DynEd\Neo\HttpClients\HttpClientInterface;

class Applicant {

    /**
     * HTTP client
     *
     * @var HttpClientInterface
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

    public static function register($email, array $payload)
    {

    }
}