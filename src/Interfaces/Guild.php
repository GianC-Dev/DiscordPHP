<?php

namespace Ourted\Interfaces;

use Ourted\Bot;
use Ourted\Model\Role\Role;

class Guild{

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

    public function getGuild($id){
        return new \Ourted\Model\Guild\Guild($this->bot, $id);
    }

    /**
     *
     * @param $guild \Ourted\Model\Guild\Guild
     * @param $role_id int|string
     * @return Role
     */
    public function getRole($guild, $role_id){
        return new Role($this->bot, $guild, $role_id);
    }

    /**
     *
     * @param $guild \Ourted\Model\Guild\Guild
     * @return Role
     */
    public function getRoles($guild){
        return new Role($this->bot, $guild);
    }


    /**
     *
     * @param $guild \Ourted\Model\Guild\Guild
     * @return mixed
     */
    public function getChannels($guild){
        return json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/channels","", "GET"));
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
    public function addRole($guild, $role_name, $color, $mentionable, $hoist){
        $result = json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/roles","{\"name\":\"{$role_name}\",  \"color\":\"{$color}\", \"hoist\":{$hoist}, \"mentionable\":{$mentionable}}", "POST"));
        return new Role($this->bot, $guild, $result->id);
    }
}