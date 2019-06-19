<?php

namespace DynEd\Neo\HttpClients;

abstract class AbstractApi
{
    /** @var HttpClientInterface */
    protected $httpClient;

    /** @var string */
    protected $baseUrl;

    /**
     * AbstractApi constructor
     *
     * @param $httpClient
     * @param $baseUrl
     */
    public function __construct(HttpClientInterface $httpClient, $baseUrl = null)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = $baseUrl;
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