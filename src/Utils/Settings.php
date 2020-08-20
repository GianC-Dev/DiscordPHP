<?php


namespace Ourted\Utils;

use Ourted\Bot;

class Settings
{

    /**
     * Bot
     *
     * @var Bot $bot
     */
    private $bot;

    /**
     * Bot Token
     *
     * @var string $token
     */
    private $token;

    public function __construct($bot)
    {
        $this->bot = $bot;
        $this->token = $bot->getToken();
    }

    /**
     * Changes Bot Username
     *
     * @var string|int $new_name New bot username
     */

    public function change_bot_username($new_name)
    {
        $this->bot->api->init_curl_with_header(
            "users/@me",
             "{\"username\":\"{$new_name}\"}", "PATCH");
    }



}