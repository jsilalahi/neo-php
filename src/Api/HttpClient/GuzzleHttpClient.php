<?php

namespace DynEd\Neo\Api\HttpClient;

use DynEd\Neo\Api\HttpClientInterface;
use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClientInterface
{
    /** @var Client */
    private $client;

    /**
     * GuzzleHttpClient constructor
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->client = new Client(
            array_merge($config, [
                'timeout'  => 5,
                'http_errors' => false
            ])
        );
    }

    /**
     * Get request
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
     * Post request
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
     * Put request
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
     * Patch request
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
     * Delete request
     *
     * @param $uri
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function delete($uri)
    {
        return $this->client->delete($uri);
    }
}