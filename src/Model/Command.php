<?php

namespace Ourted\Model;

use Ourted\Model\Channel\Channel;
use Ourted\Model\Guild\Guild;
use Ourted\Model\Channel\Message;
use React\EventLoop;
use Ourted\Bot;
use stdClass;

abstract class Command
{
    /**
     * Current bot instance
     * @var Bot $bot
     */
    protected $bot;

    /**
     * Current bot instance
     * @var stdClass $json
     */
    protected $json;

    /**
     * Curernt loop instance
     * @var EventLoop\
     */
    protected $loop;


    /**
     * Init the instance and set the bot and loop instance
     *
     * @param Bot $bot
     * @param string $command_name
     */
    public function __construct($bot, $command_name)
    {
        $this->bot = $bot;
        $bot->addDispatch('MESSAGE_CREATE', function ($json) use ($command_name, $bot) {
            $this->json = $json->d;
            if (str_starts_with($json->d->content, $bot->prefix . $command_name)) {
                $this->execute($bot->channel->getMessage($bot->channel->getChannel($json->d->channel_id), $json->d->id), $bot, $bot->channel->getChannel($json->d->channel_id), $bot->guild->getGuild($json->d->guild_id));
            }
        });
    }

    protected function getArgs(){
        $result = explode(" ", $this->json->content);
        unset($result[0]);
        return $result;
    }

    /**
     * Execute
     *
     * @param Message $message
     * @param Bot $bot
     * @param Channel $channel
     * @param Guild $guild
     *
     */
    public abstract function execute($message, $bot, $channel, $guild);
}
