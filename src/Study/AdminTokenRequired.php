<?php

namespace DynEd\Neo\Study;

use DynEd\Neo\Auth\Token;

trait AdminTokenRequired
{
    /**
     * Admin token
     *
     * @var Token
     */
    public static $adminToken;

    /**
     * Set admin token
     *
     * @param Token $token
     */
    public static function useAdminToken(Token $token)
    {
        self::$adminToken = $token;
    }
}