<?php

namespace DynEd\Neo;

use DynEd\Neo\Api\Token;
use DynEd\Neo\HttpClient\GuzzleHttpClient;
use DynEd\Neo\HttpClient\HttpClientInterface;

class Neo {

    /** @var string */
    public static $version = "1.0.0";

    /** @var HttpClientInterface */
    private $httpClient;

    /** @var array */
    private $options = [
        'client' => [
            'timeout'  => 5,
            'http_errors' => false
        ]
    ];

    /**
     * Neo constructor
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->options, $options);

        $this->httpClient = new GuzzleHttpClient(
            $this->options['client']
        );
    }

    /**
     * Token
     *
     * @param $host
     * @return Token
     */
    public function tokenRequest($host = '')
    {
        return new Token($this->httpClient, $host);
    }
}