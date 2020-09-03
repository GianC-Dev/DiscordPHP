<?php

namespace Ourted\Interfaces;

use Ourted\Bot;
use Ourted\Model\Role\Role;

class Member
{

    /** @var Bot */
    private $bot;

    public function __construct($bot)
    {
        $this->bot = $bot;
    }


    /**
     * Get User
     *
     * @param \Ourted\Model\Guild\Guild $guild
     * @param int|string $user_id
     * @return \Ourted\Model\User\Member
     */

    public function getMember($guild, $user_id)
    {
        return new \Ourted\Model\User\Member($this->bot, $guild, $user_id);
    }

    /**
     * @param \Ourted\Model\Guild\Guild $guild
     * @param string $nickname
     * @param \Ourted\Model\User\User $user
     *
     * @return mixed
     */
    public function setNickname($guild, $user, $nickname)
    {
        return json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/members/{$user->id}", "{\"nick\":\"{$nickname}\"}", "PATCH"));
    }

    /**
     * @param \Ourted\Model\Guild\Guild $guild
     * @param bool $mute
     * @param \Ourted\Model\User\User $user
     *
     */
    public function setMute($guild, $user, $mute)
    {
        return json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/members/{$user->id}", "{\"mute\":{$mute}}", "PATCH"));
    }

    /**
     * @param \Ourted\Model\Guild\Guild $guild
     * @param string $reason
     * @param \Ourted\Model\User\User $user
     *
     * @return mixed
     */
    public function setBan($guild, $user, $reason = "")
    {
        return json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/bans/{$user->id}", "{\"reason\":\"{$reason}\"}", "PUT"));
    }

    /**
     * @param \Ourted\Model\Guild\Guild $guild
     * @param string $reason
     * @param \Ourted\Model\User\User $user
     *
     * @return mixed
     */
    public function unBan($guild, $user, $reason = "")
    {
        return json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/bans/{$user->id}", "{\"reason\":\"{$reason}\"}", "DELETE"));
    }


    /**
     * @param \Ourted\Model\Guild\Guild $guild
     * @param \Ourted\Model\User\User $user
     *
     * @return mixed
     */
    public function kick($guild, $user)
    {
        return json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/members/{$user->id}", "", "DELETE"));
    }

    /**
     * @param \Ourted\Model\Guild\Guild $guild
     * @param \Ourted\Model\User\User $user
     * @param Role $role
     *
     * @return mixed
     */
    public function removeRole($guild, $user, $role)
    {
        return json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/members/{$user->id}/roles/{$role->id}", "", "DELETE"));
    }

    /**
     * @param \Ourted\Model\Guild\Guild $guild
     * @param \Ourted\Model\User\User $user
     * @param Role $role
     *
     * @return mixed
     */
    public function addRole($guild, $user, $role)
    {
        return json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/members/{$user->id}/roles/{$role->id}", "", "PUT"));
    }


}