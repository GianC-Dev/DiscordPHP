<?php

namespace Ourted\Model\Guild;

use Ourted\Bot;

class Integration
{

    public $id;
    public $name;
    public $type;
    public $enabled;
    public $syncing;
    public $role_id;
    public $enable_emoticons;
    public $expire_behavior;
    public $expire_grace_period;
    public $user;
    public $account;
    public $synced_at;

    /**
     * @param Bot $bot
     * @param int|string $guild_id
     */
    public function __construct($bot, $guild_id)
    {
        $json = json_decode($bot->api->send("guilds/{$guild_id}/integrations", "", "GET"));
        $this->id = $json->id;
        $this->name = $json->name;
        $this->type = $json->type;
        $this->enabled = $json->enabled;
        $this->syncing = $json->syncing;
        $this->role_id = $json->role_id;
        $this->enable_emoticons = $json->enable_emoticons;
        $this->expire_behavior = $json->expire_behavior;
        $this->expire_grace_period = $json->expire_grace_period;
        $this->user = $json->user;
        $this->account = $json->account;
        $this->synced_at = $json->synced_at;
        return $this;
    }
}