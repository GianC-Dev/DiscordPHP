<?php

namespace Ourted\Interfaces;

use Ourted\Bot;
use Ourted\Model\Guild\Integration;
use Ourted\Model\Guild\Role;

class Guild
{

    /** @var Bot */
    private $bot;

    public function __construct($bot)
    {
        $this->bot = $bot;
    }


    /**
     * Get guilds
     *
     * @return bool|array
     */

    public function get_guilds_properties()
    {
        return json_decode($this->bot->api->send(
            "users/@me/guilds",
            "", "GET"));
    }

    public function getGuild($id)
    {
        return new \Ourted\Model\Guild\Guild($this->bot, $id);
    }

    /**
     *
     * @param $guild \Ourted\Model\Guild\Guild
     * @param $role_id int|string
     * @return Role
     */
    public function getRole($guild, $role_id)
    {
        return new Role($this->bot, $guild, $role_id);
    }

    /**
     *
     * @param $guild \Ourted\Model\Guild\Guild
     * @return Role
     */
    public function getRoles($guild)
    {
        return new Role($this->bot, $guild);
    }


    /**
     *
     * @param $guild \Ourted\Model\Guild\Guild
     * @return mixed
     */
    public function getChannels($guild)
    {
        return json_decode($this->bot->api->send("guilds/{$guild->id}/channels", "", "GET"));
    }

    /**
     *
     * @param $guild \Ourted\Model\Guild\Guild
     * @return mixed
     */
    public function getPrune($guild)
    {
        return json_decode($this->bot->api->send("guilds/{$guild->id}/prunes", "", "GET"));
    }

    /**
     *
     * @param $guild \Ourted\Model\Guild\Guild
     * @return mixed
     */
    public function getInvites($guild)
    {
        return json_decode($this->bot->api->send("guilds/{$guild->id}/invites", "", "GET"));
    }


    /**
     *
     * @param $guild \Ourted\Model\Guild\Guild
     * @return mixed
     */
    public function getIntegrations($guild)
    {
        return new Integration($this->bot, $guild->id);
    }


    /**
     *
     * @param \Ourted\Model\Guild\Guild $guild
     * @param string $role_name
     * @param int|string $color
     * @param bool $mentionable
     * @param bool $hoist
     * @return Role
     */
    public function addRole($guild, $role_name, $color, $mentionable, $hoist)
    {
        $result = json_decode($this->bot->api->send("guilds/{$guild->id}/roles", "{\"name\":\"{$role_name}\",  \"color\":\"{$color}\", \"hoist\":{$hoist}, \"mentionable\":{$mentionable}}", "POST"));
        return new Role($this->bot, $guild, $result->id);
    }

    /**
     *
     * @param \Ourted\Model\Guild\Guild $guild
     * @param string $role_name
     * @param int|string $color
     * @param bool $mentionable
     * @param bool $hoist
     * @return Role
     */
    public function modifyRole($guild, $role_name = null, $color = null, $mentionable = null, $hoist = null)
    {
        $result = json_decode($this->bot->api->send("guilds/{$guild->id}/roles", "{\"name\":\"{$role_name}\",  \"color\":\"{$color}\", \"hoist\":{$hoist}, \"mentionable\":{$mentionable}}", "PATCH"));
        return new Role($this->bot, $guild, $result->id);
    }

    /**
     *
     * @param \Ourted\Model\Guild\Guild $guild
     * @param string|int $role_id
     * @return Role
     */
    public function deleteRole($guild, $role_id)
    {
        $result = json_decode($this->bot->api->send("guilds/{$guild->id}/roles/{$role_id}", "", "DELETE"));
        return new Role($this->bot, $guild, $result->id);
    }

    /**
     *
     * @param \Ourted\Model\Guild\Guild $guild
     * @param string
     * @param int
     * @param string
     * @param array
     * @param int
     * @param int
     * @param int
     * @param int
     * @param int
     * @param bool
     * @return \Ourted\Model\Channel\Channel
     */
    public function createChannel($guild, $channel_name, $type = 0, $topic = "", $permissions = null, $bitrate = null, $user_limit = null, $rate_limit_per_user = null, $position = null, $parent_id = null)
    {
        $field = "";
        $field .= "\"name\": \"$channel_name\"";
        $field .= ",\"type\": $type";
        $field .= ",\"topic\": \"{$topic}\"";
        if (!is_null($permissions)) {
            $n_item = "";
            foreach ($permissions as $key => $item) {
                $n_item .= $key == 0 ? $item : "," . $item;
            }
            $field .= ",\"permission_overwrites\": [{$n_item}]";
        }
        if (!is_null($bitrate)) {
            if ($type == $this->bot->CHANNEL_GUILD_VOICE) {
                $field .= ",\"bitrate\":{$bitrate} ";
            }
        }
        if (!is_null($user_limit)) {
            if ($type == $this->bot->CHANNEL_GUILD_VOICE) {
                $field .= ",\"user_limit\": {$user_limit}";
            }
        }
        if (!is_null($rate_limit_per_user)) {
            $field .= ",\"rate_limit_per_user\": {$rate_limit_per_user}";
        }
        if (!is_null($position)) {
            $field .= ",\"position\": {$position}";
        }
        if (!is_null($parent_id)) {
            $field .= ",\"parent_id\": {$parent_id}";
        }
        $result = json_decode($this->bot->api->send(
            "guilds/{$guild->id}/channels", "
            {{$field}}", "POST"));
        return new \Ourted\Model\Channel\Channel($this->bot, $result->id);
    }

    /**
     *
     * @param \Ourted\Model\Guild\Guild $guild
     * @param \Ourted\Model\Channel\Channel
     * @param int
     * @return \Ourted\Model\Channel\Channel
     */
    public function changeChannelPosition($guild, $channel, $position)
    {
        $result = json_decode($this->bot->api->send("guilds/{$guild->id}/channels", "{\"id\":{$channel->id}, \"position\":{$position}}", "PATCH"));
        return new \Ourted\Model\Channel\Channel($this->bot, $result->id);
    }
}