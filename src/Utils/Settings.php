<?php


namespace Ourted\Utils;

use Ourted\Bot;

class Settings extends Functions
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
        parent::__construct($bot);
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
        $headers = array();
        $headers[] = 'Authorization: Bot ' . $this->token;
        $headers[] = 'User-Agent: Ourted (http://example.com, v0.1)';

        $headers[] = 'Content-Type: application/json';
        $this->init_curl_with_header(
            "users/@me",
            $headers, "{\"username\":\"{$new_name}\"}", "PATCH");
    }

    /**
     * Set Error Reporting
     *
     * @var boolean|int $error Error Reporting
     */

    public function change_error_reporting($error)
    {
        error_reporting($error);
    }
}