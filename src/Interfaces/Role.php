<?php
namespace Ourted\Interfaces;

use Ourted\Bot;

class Role{

    /** @var Bot */
    private $bot;

    public function __construct($bot)
    {
        $this->bot = $bot;
    }

    /**
     *
     * @param $guild \Ourted\Model\Guild\Guild
     * @param $role_id int|string
     * @return \Ourted\Model\Role\Role
     */
    public function getRole($guild, $role_id){
        return new \Ourted\Model\Role\Role($this->bot, $guild, $role_id);
    }

    /**
     *
     * @param $guild \Ourted\Model\Guild\Guild
     * @return \Ourted\Model\Role\Role
     */
    public function getRoles($guild){
        return new \Ourted\Model\Role\Role($this->bot, $guild);
    }

    /**
     *
     * @param \Ourted\Model\Guild\Guild $guild
     * @param string $role_name
     * @param int|string $color
     * @param bool $mentionable
     * @param bool $hoist
     * @return \Ourted\Model\Role\Role
     */
    public function addRole($guild, $role_name, $color, $mentionable, $hoist){
       $result = json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/roles","{\"name\":\"{$role_name}\",  \"color\":\"{$color}\", \"hoist\":{$hoist}, \"mentionable\":{$mentionable}}", "POST"));
       return new \Ourted\Model\Role\Role($this->bot, $guild, $result->id);
    }

}