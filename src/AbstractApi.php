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
        $this->endpoints = [];
        $this->config = [
            'raw_response' => false
        ];
    }
}