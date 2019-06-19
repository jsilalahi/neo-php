<?php

namespace DynEd\Neo\AccessToken;

use DynEd\Neo\HttpClients\AbstractApi;

class Verify extends AbstractApi
{
    /**
     * Retrieve user acl, profile, token
     * 
     * @param array $data
     * @return mixed|null
     */
    public function getProfile($data = [])
    {
        // the $this->endpoint should be added inside the apps configuration
        $response = $this->httpClient->get(
            sprintf('%s/%s', $this->endpoint, 'sso/user/' . $data['username']),
            [
                'headers' => [
                    'X-Dyned-Tkn' => $data['dyned-token'],
                    'Accept' => 'application/json',
                ]
            ]
        );
        if($response->getStatusCode() == '200'){
            return json_decode($response->getBody()->getContents());
        }
        return null;
    }

    /**
     * User login, get all response from SSO
     * 
     * @param array $data
     * @return mixed|null
     */
    public function login($data = [])
    {
        $response = $this->httpClient->post(
            sprintf('%s/%s', $this->endpoint, 'jwt/token-request'),
            [   
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'json' => $data
            ]
        );
        if ($response->getStatusCode() == '200') {
            $response = json_decode($response->getBody()->getContents());
            // session(['login-token' => $response->token]);
            $data['dyned-token'] = $response->token;
            $user = $this->getProfile($data);
            $data['user'] = $user;
            // $this->superAdminTokenRequest();
            return $data;
        }
        return null;
    }
}