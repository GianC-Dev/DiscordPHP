<?php

namespace Ourted\Model\User;

use Ourted\Bot;

class User
{
    public $id;
    public $username;
    public $discriminator;
    public $avatar;
    public $verified;
    public $email;
    public $flags;
    public $premium_type;
    public $public_flags;

    /**
     *
     * @param Bot $bot Bot Instance
     * @param string|int $user_id User ID
     * @return User User Instance
     */

    public function __construct($bot, $user_id)
    {
        $json = json_decode($bot->api->init_curl_with_header("users/{$user_id}", null, "GET"));
        $this->id = $json->id ?? null;
        $this->username = $json->username ?? null;
        $this->discriminator= $json->discriminator ?? null;
        $this->avatar = $json->avatar ?? null;
        $this->verified = $json->verified ?? null;
        $this->email = $json->email ?? null;
        $this->premium_type = $json->premium_type ?? null;
        $this->public_flags = $json->public_flags ?? null;
        return $this;
    }

    public function isNull(){
        return $this->id == null;
    }

}