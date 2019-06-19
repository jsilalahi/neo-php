<?php

namespace DynEd\Neo\AccessToken;

class Token
{
    /** @var  */
    protected $token;

    /**
     * TokenResource constructor
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get token
     *
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Token to string
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->token;
    }
}