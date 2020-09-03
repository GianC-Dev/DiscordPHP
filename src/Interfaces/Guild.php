<?php

namespace Ourted\Interfaces;

use Ourted\Bot;
use Ourted\Model\Guild\Integration;
use Ourted\Model\Role\Role;

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
        return json_decode($this->bot->api->init_curl_with_header(
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
        return json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/channels", "", "GET"));
    }

    /**
     *
     * @param $guild \Ourted\Model\Guild\Guild
     * @return mixed
     */
    public function getPrune($guild)
    {
        return json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/prunes", "", "GET"));
    }

    /**
     *
     * @param $guild \Ourted\Model\Guild\Guild
     * @return mixed
     */
    public function getInvites($guild)
    {
        return json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/invites", "", "GET"));
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
        $result = json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/roles", "{\"name\":\"{$role_name}\",  \"color\":\"{$color}\", \"hoist\":{$hoist}, \"mentionable\":{$mentionable}}", "POST"));
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
        $result = json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/roles", "{\"name\":\"{$role_name}\",  \"color\":\"{$color}\", \"hoist\":{$hoist}, \"mentionable\":{$mentionable}}", "PATCH"));
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
        $result = json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/roles/{$role_id}", "", "DELETE"));
        return new Role($this->bot, $guild, $result->id);
    }

    /**
     *
     * @param \Ourted\Model\Guild\Guild $guild
     * @param string
     * @param int
     * @param string
     * @param int
     * @param int
     * @param int
     * @param int
     * @param int
     * @param bool
     * @return \Ourted\Model\Channel\Channel
     */
    public function createChannel($guild, $channel_name, $type = 0, $topic = "", $bitrate = 0, $user_limit = 0, $rate_limit_per_user = 0, $position = 0, $parent_id = 0, $nsfw = false)
    {
        $result = json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/channels", "{\"name\": \"{$channel_name}\", \"type\": {$type}, \"topic\", \"{$topic}\", \"bitrate\":{$bitrate}, \"user_limit\": {$user_limit}, \"rate_limit_per_user\": {$rate_limit_per_user}, \"position\":{$position}, \"parent_id\": {$parent_id}, \"nsfw\": {$nsfw}}", "POST"));
        return new \Ourted\Model\Channel\Channel($this->bot, $result->id);
    }

    /**
     *
     * @param \Ourted\Model\Guild\Guild $guild
     * @param \Ourted\Model\Channel\Channel
     * @param int
     */
    public function changeChannelPosition($guild, $channel, $position)
    {
        $result = json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/channels", "{\"id\":{$channel->id}, \"position\":{$position}}", "PATCH"));
        return new \Ourted\Model\Channel\Channel($this->bot, $result->id);
    }
}