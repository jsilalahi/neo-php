<?php

namespace DynEd\Neo\HttpClient;

interface HttpClientInterface
{
    /**
     * Get
     *
     * @param $uri
     * @return mixed
     */
    public function get($uri);

    /**
     * Post
     *
     * @param $uri
     * @param array $options
     * @return mixed
     */
    public function post($uri, array $options = []);

    /**
     * Put
     *
     * @param $uri
     * @param array $options
     * @return mixed
     */
    public function put($uri, array $options = []);

    /**
     * Patch
     *
     * @param $uri
     * @param array $options
     * @return mixed
     */
    public function patch($uri, array $options = []);

    /**
     * Delete
     *
     * @param $uri
     * @return mixed
     */
    public function delete($uri);
}