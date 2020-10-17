<?php

namespace Ourted\Model\Channel;

use Ourted\Bot;

class Channel
{

    public $id;
    public $type;
    public $name;
    public $guild_id;
    public $position;
    public $permission_overwrites = [];
    public $rate_limit_per_user;
    public $nsfw;
    public $topic;
    public $last_message_id;
    public $parent_id;


    /**
     * Init the instance and set the bot and loop instance
     *
     * @param Bot $bot
     * @param int|string $channel_id
     */
    public function __construct($bot, $channel_id)
    {
        $result = $bot->api->send(
            "channels/{$channel_id}",
            "", "GET");
        $json = json_decode($result);
        $this->id = $json->id ?? null;
        $this->last_message_id = $json->last_message_id ?? null;
        $this->type = $json->type ?? null;
        $this->name = $json->name ?? null;
        $this->position = $json->position ?? null;
        $this->parent_id = $json->parent_id ?? null;
        $this->topic = $json->topic ?? "";
        $this->guild_id = $json->guild_id ?? null;
        $this->nsfw = $json->nsfw ?? false;
        if (!is_null($json->permission_overwrites)){
            $n_permissions = array();
            foreach (json_decode($result, true)["permission_overwrites"] as $item){
                if($item["type"] == "role"){
                    $item["type"] = 0;
                }else{
                    $item["type"] = 1;
                }
                $n_permissions[] = array($item["id"], $item["type"], $item["allow"], $item["deny"]);
            }
            $this->permission_overwrites = $bot->channel->createOverwrite($n_permissions);
        }
        $this->rate_limit_per_user = $json->rate_limit_per_user ?? null;
        return $this;
    }

    public function isNull(){
        return $this->id == null;
    }

}
