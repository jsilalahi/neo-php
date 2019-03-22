<?php

namespace DynEd\Neo\Api;

use DynEd\Neo\Api\HttpClient\GuzzleHttpClient;

abstract class AbstractApi
{
    /** @var HttpClientInterface */
    protected $httpClient;

    /** @var string */
    protected $baseUri;

    /**
     * AbstractApi constructor
     *
     * @param HttpClientInterface $httpClient
     * @param $baseUri
     */
    public function __construct(HttpClientInterface $httpClient = null, $baseUri = null)
    {
        $this->httpClient = ($httpClient) ?: new GuzzleHttpClient();
        $this->baseUri = $baseUri;
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
     * Set Base URI / Host
     *
     * @param $baseUri
     * @return $this
     */
    public function setBaseUri($baseUri)
    {
        $this->baseUri = $baseUri;

        return $this;
    }
}