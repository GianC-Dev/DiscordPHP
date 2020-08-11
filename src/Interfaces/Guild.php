<?php

namespace Ourted\Interfaces;

use Ourted\Bot;

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

}