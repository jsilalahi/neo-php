<?php

namespace DynEd\Neo;

class Token
{
    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function __toString()
    {
        return $this->token;
    }
}