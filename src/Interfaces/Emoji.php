<?php

namespace Ourted\Interfaces;

use Ourted\Bot;

class Emoji
{

    /** @var Bot */
    private $bot;

    public function __construct($bot)
    {
        $this->bot = $bot;
    }

    /**
     * @param \Ourted\Model\Guild\Guild $guild
     * @return \Ourted\Model\Guild\Emoji
     */
    public function getEmojis($guild)
    {
        return json_decode($this->bot->api->send(
            "guilds/{$guild->id}/emojis",
            "", "GET"));
    }

    /**
     * @param \Ourted\Model\Guild\Guild $guild
     * @param string
     * @param mixed
     * @return \Ourted\Model\Guild\Emoji
     */
    public function createEmoji($guild, $name, $image)
    {
        return $this->getEmoji($guild, json_decode($this->bot->api->send(
            "guilds/{$guild->id}/emojis",
            "{\"name\":\"{$name}\",\"image\":\"{$image}\",\"roles\":\"[]\"}"))->id);
    }

    /**
     * @param \Ourted\Model\Guild\Guild $guild
     * @param $emoji_id
     * @return \Ourted\Model\Guild\Emoji
     */
    public function getEmoji($guild, $emoji_id)
    {
        return new \Ourted\Model\Guild\Emoji($this->bot, $guild->id, $emoji_id);
    }

    /**
     * @param \Ourted\Model\Guild\Guild $guild
     * @param \Ourted\Model\Guild\Emoji
     * @return \Ourted\Model\Guild\Emoji
     */
    public function deleteEmoji($guild, $emoji)
    {
        return $this->getEmoji($guild, json_decode($this->bot->api->send(
            "guilds/{$guild->id}/emojis/{$emoji->id}",
            "", "DELETE"))->id);
    }


}