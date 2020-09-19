<?php

namespace Ourted\Model\Guild;

use Ourted\Bot;

class Emoji
{

    public $id;
    public $name;
    public $roles;
    public $user;
    public $require_colons;
    public $managed;
    public $animated;

    /**
     * @param Bot $bot
     * @param int|string $guild_id
     * @param int|string $emoji_id
     */
    public function __construct($bot, $guild_id, $emoji_id)
    {
        $json = json_decode($bot->api->send("guilds/{$guild_id}/emojis/{$emoji_id}", "", "GET"));
        $this->id = $json->id ?? null;
        $this->name = $json->name ?? null;
        $this->roles = $json->roles ?? null;
        $this->user = $json->user ?? null;
        $this->require_colons = $json->require_colons ?? null;
        $this->managed = $json->managed ?? null;
        $this->animated = $json->animated ?? null;
        return $this;
    }
}