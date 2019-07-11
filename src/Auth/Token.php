<?php

namespace DynEd\Neo\Auth;

class Token
{
    /**
     * Token
     *
     * @var string
     */
    private $token;

    /**
     * Token constructor
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get token in string
     *
     * @return mixed
     */
    public function string()
    {
        return $this->token;
    }

    /**
     * Parse return decoded token, which is JWT, into human readable
     *
     * @return \Tightenco\Collect\Support\Collection
     */
    public function parse()
    {
        list($header, $payload, $signature) = explode('.', $this->token);

        return collect([
            'header' => json_decode(base64_decode($header)),
            'payload' => json_decode(base64_decode($payload)),
            'signature' => $signature
        ]);
    }

    /**
     * Token to string
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->string();
    }
}