<?php

use PHPUnit\Framework\TestCase;
use DynEd\Neo\Auth\Auth;
use DynEd\Neo\HttpClients\GuzzleHttpClient;
use DynEd\Neo\Study\Student;

class StudyStudentTest extends TestCase
{
    protected $ssoBaseUri;
    protected $ssoUsername;
    protected $ssoPassword;

    protected $auth;
    protected $student;

    public function setUp(): void
    {
        parent::setUp();

        $this->ssoBaseUri = getenv("NEO_SSO_BASE_URI");
        $this->ssoUsername = getenv("NEO_SSO_USERNAME");
        $this->ssoPassword = getenv("NEO_SSO_PASSWORD");

        $httpClient = new GuzzleHttpClient([
            'base_uri' => getenv("NEO_SSO_BASE_URI")
        ]);

        $this->auth = new Auth($httpClient);
        $this->student = new Student($httpClient);
    }

    public function testStudyStudentsOfOrganisation()
    {
        $adminToken = $this->auth->token([
            'username' => $this->ssoUsername,
            'password' => $this->ssoPassword
        ]);

        $students = $this->student->useAdminToken($adminToken)->organisation('001');

        $this->assertNotNull($students);
    }

    public function testStudyStudentSummary_AdminToken()
    {
        $adminToken = $this->auth->token([
            'username' => $this->ssoUsername,
            'password' => $this->ssoPassword
        ]);

        $students = $this->student->useAdminToken($adminToken)->organisation('001');

        $this->assertNotNull($students);

        $summary = $this->student->summary($students->data[0]->username, ['start' => '2018-01-01', 'end' => '2020-01-01']);

        $this->assertNotNull($summary);
    }

    public function testStudyStudentSummary_AdminCredential()
    {
        $students = $this->student->useAdminCredential([
            'username' => $this->ssoUsername,
            'password' => $this->ssoPassword
        ])->organisation('001');

        $this->assertNotNull($students);

        $summary = $this->student->summary($students->data[0]->username, ['start' => '2018-01-01', 'end' => '2020-01-01']);

        $this->assertNotNull($summary);
    }
}


