<?php

namespace Ourted\Utils;

use Ourted\Bot;
use Ourted\Model\Channel\Channel;
use Ourted\Model\Message\Message;

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
    public function init_curl_with_header($url, $headers, $field, $tur = "POST")
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
    public function init_curl_with_header_print_r($url, $headers, $tur = "GET")
    {
        $ch = curl_init();

        $headers[] = 'Retry-After: 500';
        $headers[] = 'X-RateLimit-Limit: 10';
        $headers[] = 'X-RateLimit-Remaining: 0';
        $headers[] = 'X-RateLimit-Reset: 147017';
        $headers[] = 'X-RateLimit-Reset-After: 5';
        $headers[] = 'X-RateLimit-Bucket: abcd1234';
        curl_setopt($ch, CURLOPT_URL, "https://discord.com/api/v6/".$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $tur);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        print_r(curl_exec($ch));
    }

    /**
     * Sending Message to Selected Channel
     *
     * @var string|int $msg Message
     * @var Channel $channel Channel Instance
     */

    public function sendMessage($msg, $channel)
    {
        $headers = array();
        $headers[] = 'Authorization: Bot ' . $this->token;
        $headers[] = 'User-Agent: Ourted (http://example.com, v0.1)';
        $headers[] = 'Content-Type: application/json';
        $this->init_curl_with_header(
            "channels/{$channel->id}/messages",
            $headers,
            "{\"content\":\"{$msg}\"}");
    }

    /**
     * Sending Message to Selected Channel
     *
     * @return bool|string
     * @var Channel $channel Channel Instance
     */

    public function getMessages($channel)
    {
        $headers = array();
        $headers[] = 'Authorization: Bot ' . $this->token;
        $headers[] = 'User-Agent: Ourted (http://example.com, v0.1)';
        $headers[] = 'Content-Type: application/json';
        return $this->init_curl_with_header(
            "channels/{$channel->id}/messages",
            $headers, "", "GET");
    }

    /**
     * Sending Message to Selected Channel
     *
     * @return Message Message Instance
     * @var string|int $message_id Message ID
     * @var Channel $channel Channel Instance
     */

    public function getMessage($channel, $message_id)
    {
        return new Message($this->bot, $message_id, $channel);

    }

    /**
     * Sending Message to Selected Channel
     *
     * @return bool|string
     * @var Message $message
     */

    public function deleteMessage($message)
    {
        echo $message->id, "\n";
        echo $message->channel_id;

        $headers = array();
        $headers[] = 'Authorization: Bot ' . $this->token;
        $headers[] = 'User-Agent: Ourted (http://example.com, v0.1)';
        $headers[] = 'Content-Type: application/json';
        return $this->init_curl_with_header(
            "channels/{$message->channel_id}/messages/{$message->id}",
            $headers, "", "DELETE");
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

    public function get_channel($channel_id){
        return new \Ourted\Model\Channel\Channel($this->bot, $channel_id);
    }

}
