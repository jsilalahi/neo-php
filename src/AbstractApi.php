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
     * API configuration
     *
     * @var array
     */
    protected $config = [];

    /**
     * AbstractApi constructor
     *
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->configureDefaults();
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

    /**
     * Get endpoints
     *
     * @param null $name
     * @return array|mixed|null
     */
    public function getEndpoints($name = null)
    {
        return $name === null
            ? $this->endpoints
            : (isset($this->endpoints[$name]) ? $this->endpoints[$name] : null);
    }

    /**
     * Get config
     *
     * @param null $name
     * @return array|mixed|null
     */
    public function getConfig($name = null)
    {
        return $name === null
            ? $this->config
            : (isset($this->configs[$name]) ? $this->config[$name] : null);
    }

    /**
     * Configure default value
     *
     * @return void
     */
    protected function configureDefaults()
    {
        $this->endpoints = [];
        $this->config = [
            'raw_response' => false
        ];
    }
}