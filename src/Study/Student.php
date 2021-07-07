<?php

namespace DynEd\Neo\Study;

use DynEd\Neo\AbstractApi;
use DynEd\Neo\AdminTokenTrait;
use DynEd\Neo\Exceptions\ValidationException;
use Rakit\Validation\Validator;

class Student extends AbstractApi
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
            'organisation' => '/api/v1/dsa/report/student?org_code=%s&page=%s',
            'summary' => '/api/v1/dsa/report/student/%s?starttime=%s&endtime=%s'
        ];
    }

    /**
     * Retrieve students from organisation
     *
     * @param $uic
     * @param $page
     * @return mixed|null
     * @throws \DynEd\Neo\Exceptions\ConfigurationException
     */
    public function organisation($uic, $page = 1)
    {
        $this->httpClientSetOrFail()->adminTokenSetOrFail();

        $response = $this->httpClient->get(
            sprintf($this->getEndpoints('organisation'), $uic, $page),
            [
                'headers' => [
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

        return json_decode($raw);
    }

    /**
     * Study summary of given student in range of period
     *
     * @param $username
     * @param array $period
     * @return mixed|null
     * @throws \DynEd\Neo\Exceptions\ConfigurationException
     * @throws \DynEd\Neo\Exceptions\ValidationException
     */
    public function summary($username, array $period)
    {
        $this->httpClientSetOrFail()->adminTokenSetOrFail();

        $validation = (new Validator)->validate($period, [
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        if ($validation->fails()) {
            throw new ValidationException("missing or invalid period start or end");
        }

        $response = $this->httpClient->get(
            sprintf($this->getEndpoints('summary'), $username, $period['start'], $period['end']),
            [
                'headers' => [
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

        return json_decode($raw);
    }
}