<?php

use PHPUnit\Framework\TestCase;
use DynEd\Neo\Auth\Token;

class AuthTokenTest extends TestCase
{
    protected $username;

    public function setUp(): void
    {
        parent::setUp();

        $this->username = getenv("NEO_SSO_USERNAME");
    }

    public function testToken()
    {
        $jwt = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE1NjU1MzE5MjIsImV4cGlyYXRpb24iOjE1NjU1MzE5MjIsInVzZXJuYW1lIjoidGViZXR1dGFyYTIiLCJ1dWlkIjoiMTcxIn0.j76IrcazFSM0jQCTu5SvG-itBagjt6jNMFjo48z3gtgwZZGOkq9E4DapVzSOu2RRD1IND82dbqmm-z6ibRsF_KRyXivd-WHTh9eZbXHDY5a6HEAVkb-HKV5bJzALiYBm5CRZwUMe8JHVSpyJOrpW_AoXAvjObrY5KCkNeBJ_noqw2VDzVBr3JERIE9zGEAqEEATOjEVbdqpolJJJTbysyWqypLbANyyniHgKatuBzeJg85HbpuPK-I0-im5caF0zw1Om8ISP8005USuVtCgBd8yNNEalQkxyjWpAG2NDBJtVIZbAILslWPIa8oLuJS1yYmCKi0e_cCTD38A2InIGAw';

        $token = new Token($jwt);

        $this->assertEquals($jwt, $token->string());
        $this->assertEquals($jwt, $token);
        $this->assertEquals($this->username, $token->parse()->get('payload')->username);
    }
}


