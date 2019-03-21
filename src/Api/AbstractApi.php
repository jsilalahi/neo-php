<?php

namespace Neo\Api;

use Neo\HttpClient\HttpClientInterface;

abstract class AbstractApi
{
    /** @var HttpClientInterface */
    protected $httpClient;

    /** @var string */
    protected $baseUrl;

    /**
     * AbstractApi constructor
     *
     * @param HttpClientInterface $httpClient
     * @param $baseUrl
     */
    public function __construct(HttpClientInterface $httpClient, $baseUrl)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = $baseUrl;
    }
}