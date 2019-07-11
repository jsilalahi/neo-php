<?php

namespace DynEd\Neo;

use DynEd\Neo\Auth\Auth;
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

    /**
     * Set admin credential
     *
     * @param array $credential
     * @return $this
     * @throws Exceptions\ConfigurationException
     * @throws Exceptions\ValidationException
     */
    public function useAdminCredential(array $credential)
    {
        $auth = new Auth($this->httpClient);

        $this->adminToken = $auth->token($credential);

        return $this;
    }
}