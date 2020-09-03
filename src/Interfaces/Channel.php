<?php

namespace Ourted\Interfaces;

use Ourted\Bot;
use Ourted\Model\Message\Message;

class Channel{

    /** @var Bot */
    private $bot;

    public function __construct($bot)
    {
        $this->bot = $bot;
    }

    public function getChannel($channel_id){
        return new \Ourted\Model\Channel\Channel($this->bot, $channel_id);
    }


    /**
     * Sending Message to Selected Channel
     *
     * @var string $message
     * @var \Ourted\Model\Channel\Channel $channel
     */

    public function sendMessage($message, $channel){
        $this->bot->api->init_curl_with_header(
            "channels/{$channel->id}/messages",
            "{\"content\":\"{$message}\"}");
    }

    /**
     * Deleting Message
     *
     * @return bool|string
     * @var Message $message
     */

    public function deleteMessage($message)
    {
        return $this->bot->api->init_curl_with_header(
            "channels/{$message->channel_id}/messages/{$message->id}",
            "", "DELETE");
    }

    /**
     * Deleting Message
     *
     * @return bool|array
     * @var string $message
     * @var \Ourted\Model\Channel\Channel $channel
     */

    public function deleteBulkMessage($message, $channel)
    {
        return json_decode($this->bot->api->init_curl_with_header(
            "channels/{$channel->id}/messages/bulk-delete",
            "{\"messages\":{$message}}", "POST"));
    }

    /**
     * Getting Messages in Selected Channel
     *
     * @return bool|array
     * @var \Ourted\Model\Channel\Channel $channel Channel Instance
     */

    public function getMessages($channel)
    {
        return json_decode($this->bot->api->init_curl_with_header(
            "channels/{$channel->id}/messages",
            "", "GET"));
    }

    /**
     * Getting Message in Selected Channel
     *
     * @return Message Message Instance
     * @var string|int $message_id Message ID
     * @var \Ourted\Model\Channel\Channel $channel Channel Instance
     */

    public function getMessage($channel, $message_id)
    {
        return new Message($this->bot, $message_id, $channel);
    }

    /**
     *
     * @param $channel \Ourted\Model\Channel\Channel
     * @return mixed
     */
    public function deleteChannel($channel){
        return json_decode($this->bot->api->init_curl_with_header("channels/{$channel->id}","", "DELETE"));
    }

}