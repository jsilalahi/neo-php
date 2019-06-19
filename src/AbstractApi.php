<?php

namespace DynEd\Neo;

use DynEd\Neo\HttpClients\GuzzleHttpClient;
use DynEd\Neo\HttpClients\HttpClientInterface;

abstract class AbstractApi
{
    /** @var HttpClientInterface */
    protected $httpClient;

    /** @var string */
    protected $baseUrl;

    /**
     * AbstractApi constructor
     *
     * @param $baseUrl
     * @param $httpClient
     */
    public function __construct($baseUrl = null, HttpClientInterface $httpClient = null)
    {
        $this->baseUrl = $baseUrl;
        $this->httpClient = ($httpClient) ?: new GuzzleHttpClient();
    }

    /**
     * Set HttpClient
     *
     * @param HttpClientInterface $httpClient
     * @return $this
     */
    public function setHttpClient(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * Set base URL
     *
     * @param $baseUrl
     * @return $this
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }
}