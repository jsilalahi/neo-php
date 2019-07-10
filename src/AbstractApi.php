<?php

namespace DynEd\Neo;

use DynEd\Neo\Exceptions\ConfigurationException;
use DynEd\Neo\HttpClients\HttpClientInterface;

abstract class AbstractApi
{
    /**
     * HTTP client
     *
     * @var HttpClientInterface
     */
    protected $httpClient = null;

    /**
     * API endpoints
     *
     * @var array
     */
    protected $endpoints = [];

    /**
     * AbstractApi constructor
     *
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Setup HTTP client
     *
     * @param HttpClientInterface $httpClient
     */
    public function useHttpClient(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Check whether HTTP client set
     *
     * @return bool
     */
    protected function isHttpClientSet()
    {
        return ($this->httpClient) ? true : false;
    }

    /**
     * Check whether HTTP client set or throw an exception
     *
     * @throws ConfigurationException
     */
    protected function httpClientSetOrFail()
    {
        if( ! $this->isHttpClientSet()) {
            throw new ConfigurationException("missing http client");
        }
    }


}