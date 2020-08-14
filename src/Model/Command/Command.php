<?php

namespace Ourted\Model\Command;

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
                $res = $this->execute($this->bot->channel->getMessage($bot->channel->getChannel($json->d->channel_id), intval($json->d->id)), $bot);
                if(isset(json_decode($res)->message)){
                    $this->onFail(json_decode($res)->message, $this->bot);
                }
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
     * @param stdClass $message
     * @param Bot $bot
     *
     */
    public abstract function execute($message, $bot);

    /**
     * On Fail
     *
     * @param string $fail
     * @param Bot $bot
     *
     */
    public function onFail($fail, $bot){

    }

}
