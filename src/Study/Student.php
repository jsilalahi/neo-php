<?php

namespace DynEd\Neo\Study;

use DynEd\Neo\AbstractApi;

class Student extends AbstractApi
{
    use AdminTokenRequired;

    /**
     * Endpoint to retrieve students from organisation
     *
     * @var string
     */
    const STUDENTS_ENDPOINT = '/api/v1/dsa/report/student?org_code=%s&page=%s';

    /**
     * Endpoint to retrieve study summary of student in range of period
     *
     * @var string
     */
    const STUDENT_SUMMARY_ENDPOINT = '/api/v1/dsa/report/student/%s?starttime=%s&endtime=%s';

    /**
     * Error message when period is not complete
     *
     * @var string
     */
    private static $errPeriod = "missing or invalid period start or end";

    /**
     * Retrieve student from organisation
     *
     * @param $uic
     * @param $page
     * @return mixed|null
     * @throws \DynEd\Neo\Exceptions\ConfigurationException
     */
    public static function organisation($uic, $page = 1)
    {
        self::httpClientSetOrFail();

        $response = self::$httpClient->get(sprintf(self::STUDENTS_ENDPOINT, $uic, $page),
            [
                'headers' => [
                    'X-DynEd-Tkn' => self::$adminToken->string()
                ]
            ]
        );

        if ($response->getStatusCode() == '200') {
            return  json_decode($response->getBody()->getContents());
        }

        return null;
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
    public static function summary($username, array $period)
    {
        self::httpClientSetOrFail();

        self::validate($period, [
            'start' => 'required|date',
            'end' => 'required|date',
        ], self::$errPeriod);

        $response = self::$httpClient->get(sprintf(self::STUDENT_SUMMARY_ENDPOINT, $username, $period['start'], $period['end']),
            [
                'headers' => [
                    'X-DynEd-Tkn' => self::$adminToken->string()
                ]
            ]
        );

        if ($response->getStatusCode() == '200') {
            return  json_decode($response->getBody()->getContents());
        }

        return null;
    }
}