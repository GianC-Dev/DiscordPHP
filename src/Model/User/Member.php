<?php

namespace Ourted\Model\User;

use Ourted\Bot;
use Ourted\Model\Guild\Guild;

class Member
{
    public $id;
    public $user = [];
    public $nick;
    public $roles = [];
    public $joined_at;
    public $deaf;
    public $mute;

    /**
     *
     * @param Bot $bot Bot Instance
     * @param Guild $guild Guild Instance
     * @param string|int $user_id User ID
     */

    public function __construct($bot, $guild, $user_id)
    {
        $json = json_decode($bot->api->send("guilds/{$guild->id}/members/{$user_id}", null, "GET"));
        $this->id = $user_id ?? null;
        $this->user = $json->user ?? null;
        $this->roles = $json->roles ?? null;
        $this->joined_at = $json->joined_at ?? null;
        $this->deaf = $json->deaf ?? null;
        $this->mute = $json->mute ?? null;
        return $this;
    }

    public function isNull(){
        return $this->id == null;
    }

}