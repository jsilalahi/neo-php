<?php

namespace DynEd\Neo\Auth;

use Tightenco\Collect\Support\Collection;

class User {
    /**
     * User token
     *
     * @var Token
     */
    protected $token;

    /**
     * User ACL
     *
     * @var Collection
     */
    protected $acl;

    /**
     * User profile
     *
     * @var Collection
     */
    protected $profile;

    /**
     * User constructor
     *
     * @param Token $token
     * @param $acl
     * @param $profile
     */
    public function __construct(Token $token, $acl, $profile)
    {
        $this->token = $token;
        $this->acl = $acl;
        $this->profile = $profile;

        return $this;
    }

    /**
     * Create is static method to help creating user
     *
     * @param array $data
     * @return User
     */
    public static function create(array $data)
    {
        $token = $data['token'];

        $acl = collect(
            json_decode(
                json_encode(
                    $data['acl']
                ), true
            )
        );

        $profile = collect(
            json_decode(
                json_encode(
                    $data['profile']
                ), true
            )
        );

        return new User($token, $acl, $profile);
    }

    /**
     * Retrieve user's token
     *
     * @return Token
     */
    public function token()
    {
        return $this->token;
    }

    /**
     * Retrieve user's profile
     *
     * @param $key
     * @return Collection
     */
    public function profile($key = null)
    {
        if($key) {
            return $this->profile->get($key);
        }
        return $this->profile;
    }

    /**
     * Retrieve user's ACL
     *
     * @param $key
     * @return Collection
     */
    public function acl($key = null)
    {
        if($key) {
            return $this->acl->get($key);
        }
        return $this->acl;
    }
}