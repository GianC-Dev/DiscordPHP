<?php

namespace Ourted\Interfaces;

use Ourted\Bot;
use Ourted\Model\Channel\Message;
use Ourted\Model\Channel\Overwrite;

class Channel
{

    /** @var Bot */
    private $bot;

    public function __construct($bot)
    {
        $this->bot = $bot;
    }

    public function getChannel($channel_id)
    {
        return new \Ourted\Model\Channel\Channel($this->bot, $channel_id);
    }


    /**
     * Sending Message to Selected Channel
     *
     * @var string $message
     * @var \Ourted\Model\Channel\Channel $channel
     */

    public function sendMessage($message, $channel)
    {
        $this->bot->api->send(
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
        return $this->bot->api->send(
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
        return json_decode($this->bot->api->send(
            "channels/{$channel->id}/messages/bulk-delete",
            "{\"messages\":{$message}}", "POST"));
    }

    /**
     * Getting Messages in Selected Channel
     *
     * @return bool|array
     * @var \Ourted\Model\Channel\Channel $channel Channel Instance
     * @var int $limit
     */

    public function getMessages($channel, $limit = 50)
    {
        return json_decode($this->bot->api->send(
            "channels/{$channel->id}/messages?limit={$limit}",
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
    public function deleteChannel($channel)
    {
        return json_decode($this->bot->api->send("channels/{$channel->id}", "", "DELETE"));
    }

    /**
     * @param array $overwrites
     * @return array
     */
    public function createOverwrite(array ...$overwrites)
    {
        $r = array();
        array_keys($overwrites);
        foreach ($overwrites as $item) {
            $id = $item[0];
            $type = $item[1];
            $allow = $item[2];
            $deny = $item[3];
            $o = new Overwrite($id, $type, $allow, $deny);
            $r[] = $o->create_object();
        }
        return $r;
    }
}