<?php

namespace DynEd\Neo\HttpClients;

interface HttpClientInterface
{
    /**
     * Get
     *
     * @param $uri
     * @param array $options
     * @return mixed
     */
    public function get($uri, array $options = []);

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