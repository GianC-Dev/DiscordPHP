<?php
namespace Ourted\Interfaces;

use Ourted\Bot;

class User{

    /** @var Bot */
    private $bot;

    public function __construct($bot)
    {
        $this->bot = $bot;
    }


    /**
     * Get User
     *
     * @param int|string $user_id
     * @return \Ourted\Model\User\User User Instance
     */

    public function getUser($user_id)
    {
        return new \Ourted\Model\User\User($this->bot, $user_id);
    }

    /**
     * @param \Ourted\Model\Guild\Guild $guild
     * @param string $nickname
     * @param \Ourted\Model\User\User $user
     *
     */
    public function setNickname($guild, $user, $nickname){
        return json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/members/{$user->id}","{\"nick\":\"{$nickname}\"}", "PATCH"));
    }

    /**
     * @param \Ourted\Model\Guild\Guild $guild
     * @param bool $mute
     * @param \Ourted\Model\User\User $user
     *
     */
    public function setMute($guild, $user, $mute){
        return json_decode($this->bot->api->init_curl_with_header("guilds/{$guild->id}/members/{$user->id}","{\"mute\":{$mute}}", "PATCH"));
    }





}