<?php

namespace Ourted\Model\Role;

use Ourted\Bot;
use Ourted\Interfaces\Guild;

class Role
{
    public $id;
    public $name;
    public $color;
    public $hoist;
    public $position;
    public $permissions;
    public $permissions_new;
    public $managed;
    public $mentionable;

    /**
     *
     * @param Bot $bot
     * @param \Ourted\Model\Guild\Guild $guild
     * @param int|string $role_id
     */
    public function __construct($bot, $guild, $role_id = 000)
    {
        $json = json_decode($bot->api->init_curl_with_header("guilds/{$guild->id}/roles", "", "GET"));
        if($role_id != 000) {
            foreach ($json as $key => $item) {
                if ($item->id == $role_id) {
                    $json = $item;
                }
            }
        }
        $this->id = $json->id ?? null;
        $this->name = $json->name ?? null;
        $this->color = $json->color ?? null;
        $this->hoist = $json->hoist ?? null;
        $this->position = $json->position ?? null;
        $this->permissions = $json->permissions ?? null;
        $this->permissions_new = $json->permissions_new ?? null;
        $this->managed = $json->managed ?? null;
        $this->mentionable = $json->mentionable ?? null;
        return $this;
    }
}