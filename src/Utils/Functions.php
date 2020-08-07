<?php

namespace Ourted\Utils;

use Ourted\Bot;

class Functions
{
    /**
     * Bot
     *
     * @var Bot $bot
     */
    private $bot;

    /**
     * Interval
     *
     * @var array $interval
     */
    private $interval;

    /**
     * Bot Token
     *
     * @var string $token
     */
    private $token;

    /**
     *
     * @var Bot $bot
     */
    public function __construct($bot)
    {
        $this->bot = $bot;
        $this->token = $bot->getToken();
    }

    /**
     * Init Curl With Header
     *
     * @return bool|string
     * @var string $field CURLOPT_POST
     * @var string|null $tur CURLOPT_CUSTOMREQUEST
     * @var string $url CURLOPT_URL
     * @var array $headers CURLOPT_HTTPHEADER
     */
    protected function init_curl_with_header($url, $headers, $field, $tur = "POST")
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://discord.com/api/v6/".$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $tur);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $field);
        $headers[] = 'Retry-After: 500';
        $headers[] = 'X-RateLimit-Limit: 10';
        $headers[] = 'X-RateLimit-Remaining: 0';
        $headers[] = 'X-RateLimit-Reset: 147017';
        $headers[] = 'X-RateLimit-Reset-After: 5';
        $headers[] = 'X-RateLimit-Bucket: abcd1234';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        return curl_exec($ch);
    }

    /**
     * Init Curl With Header
     *
     * @var array $headers CURLOPT_HTTPHEADER
     * @var string $field CURLOPT_POST
     * @var string|null $tur CURLOPT_CUSTOMREQUEST
     * @var string $url CURLOPT_URL
     */
    protected function init_curl_with_header_print_r($url, $headers, $tur = "POST")
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $tur);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        print_r(curl_exec($ch));
    }

    /**
     * Sending Message to Selected Channel
     *
     * @var string|int $msg Message
     * @var string|int $channel_id Channel ID
     */

    public function sendMessage($msg, $channel_id)
    {
        $headers = array();
        $headers[] = 'Authorization: Bot ' . $this->token;
        $headers[] = 'User-Agent: Ourted (http://example.com, v0.1)';
        $headers[] = 'Content-Type: application/json';
        $this->init_curl_with_header(
            "channels/{$channel_id}/messages",
            $headers,
            "{\"content\":\"{$msg}\"}");
    }



    /**
     * Get guilds
     *
     * @return bool|string
     */

    public function get_guilds_properties()
    {
        $headers = array();
        $headers[] = 'Authorization: Bot ' . $this->token;
        $headers[] = 'User-Agent: Ourted (http://example.com, v0.1)';
        $headers[] = 'Content-Type: application/json';
        return $this->init_curl_with_header(
            "users/@me/guilds",
            $headers, "", "GET");
    }

}
