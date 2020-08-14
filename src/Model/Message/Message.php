<?php

namespace Ourted\Model\Message;

use Ourted\Bot;
use Ourted\Model\Channel\Channel;

class Message extends \stdClass
{
    public $id;
    public $reactions = [];
    public $attachments = [];
    public $tts;
    public $embeds = [];
    public $timestamp;
    public $mention_everyone;
    public $pinned;
    public $edited_timestamp;
    public $author = [];
    public $mention_roles = [];
    public $content;
    public $channel_id;
    public $mentions = [];
    public $type;
    public $flags;
    public $message_reference = [];
    public $guild_id = [];


    /**
     * @param Bot $bot Bot Instance
     * @param Channel $channel Channel Instance
     * @param string|int $message_id Message ID
     */
    public function __construct($bot, $message_id, $channel)
    {
        $result = json_decode($bot->api->init_curl_with_header(
            "channels/{$channel->id}/messages/{$message_id}",
            "", "GET"));

        $this->id = $result->id ?? null;
        $this->reactions = $result->reactions ?? null;
        $this->attachments = $result->attachments ?? null;
        $this->tts = $result->tts ?? null;
        $this->embeds = $result->embeds ?? null;
        $this->content = $result->content ?? null;
        $this->type = $result->type ?? null;
        $this->channel_id = $result->channel_id ?? null;
        $this->author = $result->author ?? null;
        $this->edited_timestamp = $result->edited_timestamp ?? null;
        $this->timestamp = $result->timestamp ?? null;
        $this->mention_everyone = $result->mention_everyone ?? null;
        $this->pinned = $result->pinned ?? null;
        $this->mention_roles = $result->mentioned_roles ?? null;
        $this->mentions = $result->mentions ?? null;
        $this->message_reference = $result->message_reference ?? null;
        $this->guild_id = $result->guild_id ?? null;
        return $this;
    }
}