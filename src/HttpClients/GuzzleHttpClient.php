<?php

namespace DynEd\Neo\HttpClients;

use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClientInterface
{
    /**
     * HTTP client
     *
     * @var Client
     */
    private $client;

    /**
     * HTTP client config
     *
     * @var array
     */
    private $config = [
        'timeout'  => 5,
        'http_errors' => false,
        'verify' => false
    ];

    /**
     * GuzzleHttpClient constructor
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->client = new Client(
            array_merge($this->config, $config)
        );
    }

    /**
     * Get
     *
     * @param $uri
     * @param array $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function get($uri, array $options = [])
    {
        return $this->client->get($uri, $options);
    }

    /**
     * Post
     *
     * @param $uri
     * @param array $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function post($uri, array $options = [])
    {
        return $this->client->post($uri, $options);
    }

    /**
     * Put
     *
     * @param $uri
     * @param array $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function put($uri, array $options = [])
    {
        return $this->client->put($uri, $options);
    }

    /**
     * Patch
     *
     * @param $uri
     * @param array $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function patch($uri, array $options = [])
    {
        return $this->client->patch($uri, $options);
    }

    /**
     * Delete
     *
     * @param $uri
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function delete($uri)
    {
        return $this->client->delete($uri);
    }
}