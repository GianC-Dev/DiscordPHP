<?php

namespace Ourted\Model\Invite;

use Ourted\Bot;

class Invite
{

    public $code;
    public $guild;
    public $channel;
    public $inviter;
    public $target_user;
    public $target_user_type;

    /**
     * @param Bot $bot
     * @param int|string $invite_code
     */
    public function __construct($bot, $invite_code)
    {
        $json = json_decode($bot->api->init_curl_with_header("invites/{$invite_code}", "", "GET"));
        $this->code = $json->code ?? null;
        $this->guild = $bot->guild->getGuild($json->guild->id) ?? null;
        $this->channel = $bot->channel->getChannel($json->channel->id) ?? null;
        $this->inviter = $bot->user->getUser($json->inviter->id) ?? null;
        $this->target_user = $bot->user->getUser($json->target_user->id) ?? null;
        $this->target_user_type = $json->target_user_type ?? null;
        return $this;
    }
}