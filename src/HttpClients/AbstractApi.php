<?php

namespace DynEd\Neo\HttpClients;

abstract class AbstractApi
{
    /** @var HttpClientInterface */
    protected $httpClient;

    /** @var string */
    protected $endpoint;

    /**
     * AbstractApi constructor
     *
     * @param $endpoint
     */
    public function __construct($endpoint = null)
    {
        $this->httpClient = new GuzzleHttpClient();
        $this->endpoint = $endpoint;
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
     * Set endpoint
     *
     * @param $endpoint
     * @return $this
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }
}