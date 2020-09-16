<?php

namespace Ourted\Model\Webhook;

use Ourted\Bot;

class Webhook
{

    public $type;
    public $id;
    public $name;
    public $avatar;
    public $channel_id;
    public $guild_id;
    public $application_id;
    public $token;
    public $user;
    
    /**
     *
     * @param Bot $bot Bot Instance
     * @param string|int $webhook_id User ID
     */

    public function __construct($bot,  $webhook_id)
    {
        $json = json_decode($bot->api->init_curl_with_header("webhooks/{$webhook_id}", null, "GET"));
        $this->type = $json->type ?? null;
        $this->id = $json->id ?? null;
        $this->name = $json->name ?? null;
        $this->avatar = $json->avatar ?? null;
        $this->channel_id = $json->channel_id ?? null;
        $this->guild_id = $json->guild_id ?? null;
        $this->application_id = $json->application_id ?? null;
        $this->token = $json->token ?? null;
        $this->user = $bot->user->getUser($json->user->id) ?? null;
        return $this;
    }
}