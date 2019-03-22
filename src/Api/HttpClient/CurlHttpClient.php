<?php

namespace DynEd\Neo\Api\HttpClient;

use DynEd\Neo\Api\HttpClientInterface;

class CurlHttpClient implements HttpClientInterface
{
    /**
     * Get request
     *
     * @param $uri
     * @param array $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function get($uri, array $options = [])
    {
        // TODO
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
        // TODO
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
        // TODO
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
        // TODO
    }

    /**
     * Delete request
     *
     * @param $uri
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function delete($uri)
    {
        // TODO
    }
}