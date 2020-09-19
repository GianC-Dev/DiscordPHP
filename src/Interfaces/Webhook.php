<?php

namespace Ourted\Interfaces;

use Ourted\Bot;

class Webhook{

    /** @var Bot */
    private $bot;

    public function __construct($bot)
    {
        $this->bot = $bot;
    }

    /**
     * @return mixed
     * @var \Ourted\Model\Channel\Channel
     * @var string
     * @var string
     */

    public function createWebhook($channel,$name, $avatar_image_data = null){
        $bot = $this->bot;
        $field = "\"name\": \"{$name}\"";
        if(!is_null($avatar_image_data)){
            $field .= ", \"avatar\": \"{$avatar_image_data}\"";
        }
        return new \Ourted\Model\Webhook\Webhook($bot, json_decode($bot->api->send("channels/{$channel->id}/webhooks", "{{$field}}"))->id);
    }
}