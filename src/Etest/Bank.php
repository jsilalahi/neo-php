<?php

namespace DynEd\Neo\Etest;

use DynEd\Neo\AbstractApi;
use DynEd\Neo\AdminTokenTrait;
use Tightenco\Collect\Support\Collection;

class Bank extends AbstractApi
{
    use AdminTokenTrait;

    /**
     * Configure default value
     *
     * @return void
     */
    protected function configure()
    {
        parent::configure();

        $this->endpoints = [
            'questions' => '/banks/question'
        ];
    }

    /**
     * Retrieve questions
     *
     * @return Collection|null
     * @throws \DynEd\Neo\Exceptions\ConfigurationException
     */
    public function questions()
    {
        $this->httpClientSetOrFail();

        $response = $this->httpClient->post($this->getEndpoints('question'),
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-DynEd-Tkn' => $this->adminToken->string()
                ]
            ]
        );

        if ($response->getStatusCode() != '200') {
            return null;
        }

        $raw = $response->getBody()->getContents();

        if($this->getConfig('raw_response')) {
            return $raw;
        }

        $questions = [];
    }
}