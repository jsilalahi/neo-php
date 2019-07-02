<?php

namespace DynEd\Neo\Study;

use DynEd\Neo\AbstractApi;
use DynEd\Neo\Auth\Token;

class Admin extends AbstractApi {

    /**
     * Endpoint to retrieve students summary report per organisation
     *
     * var @string
     */
    const STUDENTS_SUMMARY_ORGANISATION_ENDPOINT = "/api/v1/dsa/report/student-summary-report";

    /**
     * Endpoint to retrieve student summary report for period
     */
    const STUDENT_SUMMARY_PERIOD_ENDPOINT = "/api/v1/dsa/admin/student-summary/%s?startime=%s&endtime=%s";

    /**
     * Error message when period is not complete
     *
     * @var string
     */
    private static $errCredential = "missing or invalid period start or end";

    /**
     * Admin token
     *
     * @var Token
     */
    private static $adminToken;

    /**
     * Set admin token
     *
     * @param Token $token
     */
    public static function setAdminToken(Token $token)
    {
        self::$adminToken = $token;
    }

    /**
     * Retrieve students summary report of given $uic organisation
     *
     * @param $uic
     * @return mixed|null
     * @throws \DynEd\Neo\Exceptions\ConfigurationException
     */
    public static function studentsSummaryOrganisation($uic)
    {
        self::httpClientSetOrFail();

        $response = self::$httpClient->post(self::STUDENTS_SUMMARY_ORGANISATION_ENDPOINT,
            [
                'form_params' => [
                    'org_code' => $uic,
                ],
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
     * Retrieve student summary report for given period
     *
     * @param $username
     * @param array $period
     * @return mixed|null
     * @throws \DynEd\Neo\Exceptions\ConfigurationException
     * @throws \DynEd\Neo\Exceptions\ValidationException
     */
    public static function studentSummaryPeriod($username, array $period)
    {
        self::httpClientSetOrFail();

        self::validate($period, [
            'start' => 'required|date',
            'end' => 'required|date',
        ], self::$errCredential);

        $response = self::$httpClient->post(sprintf(self::STUDENT_SUMMARY_PERIOD_ENDPOINT, $username, $period['start'], $period['end']),
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