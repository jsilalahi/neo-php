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
     * @param $endpoints
     * @param $config
     */
    public function __construct(HttpClientInterface $httpClient, $endpoints = [], $config = [])
    {
        $this->httpClient = $httpClient;
        $this->endpoints = $endpoints;
        $this->config = $config;

        $this->configure();
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
     * @param null $key
     * @return array|mixed|null
     */
    public function getEndpoints($key = null)
    {
        return $key === null
            ? $this->endpoints
            : (isset($this->endpoints[$key]) ? $this->endpoints[$key] : null);
    }

    /**
     * Set config
     *
     * @param $key
     * @param null $value
     */
    public function setEndpoints($key, $value = null)
    {
        if(is_array($key)) {
            foreach ($key as $k => $v) {
                $this->setEndpoints($k, $v);
            }

            return;
        }

        $this->endpoints[$key] = $value;
    }

    /**
     * Get config
     *
     * @param null $key
     * @return array|mixed|null
     */
    public function getConfig($key = null)
    {
        return $key === null
            ? $this->config
            : (isset($this->config[$key]) ? $this->config[$key] : null);
    }

    /**
     * Set config
     *
     * @param $key
     * @param null $value
     */
    public function setConfig($key, $value = null)
    {
        if(is_array($key)) {
            foreach ($key as $k => $v) {
                $this->setConfig($k, $v);
            }

            return;
        }

        $this->config[$key] = $value;
    }

    /**
     * Configure default value
     *
     * @return void
     */
    protected function configure()
    {
        if( ! $this->endpoints) {
            $this->endpoints = [];
        }

        if( ! $this->endpoints) {
            $this->config = [
                'raw_response' => false // By default, API return an object / encoded
            ];
        }
    }
}