<?php

namespace DynEd\Neo;

use DynEd\Neo\Auth\Token;

trait AdminTokenTrait
{
    /**
     * Admin token
     *
     * @var Token
     */
    public $adminToken;

    /**
     * Set admin token
     *
     * @param Token $token
     * @return $this
     */
    public function useAdminToken(Token $token)
    {
        $this->adminToken = $token;

        return $this;
    }
}