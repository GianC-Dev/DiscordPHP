<?php


namespace Ourted\Interfaces;

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
        $this->bot->api->send(
            "users/@me",
            "{\"username\":\"{$new_name}\"}", "PATCH");
    }

    /**
     * Updates Presence Of Bot
     *
     * @var string|int $new_name New bot username
     * @var int $game_type
     */

    public function change_bot_presence($new_presence, $game_type)
    {
        $this->bot->getConnection()->send(json_encode([
            "op" => 3,
            "d" => [
                "since" => 91879201,
                "game" => [
                    "name" => "{$new_presence}",
                    "type" => $game_type
                ],
                "status" => "dnd",
                "afk" => false
            ]
        ]));
    }


}