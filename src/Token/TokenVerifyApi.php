<?php

namespace DynEd\Neo\Token;

use DynEd\Neo\Api\AbstractApi;

class TokenVerifyApi extends AbstractApi
{
    /** @var string */
    const ENDPOINT = "/token-verify";

    /** @var TokenResource */
    protected $token;

    /**
     * Set token to verify
     *
     * @param TokenResource $token
     * @return $this
     */
    public function setToken(TokenResource $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Verify
     *
     * @return void
     */
    public function verify()
    {

    }
}