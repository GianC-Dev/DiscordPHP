<?php

namespace Ourted\Interfaces;

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
        $bot->addDispatch('MESSAGE_CREATE', $command_name, function ($json) use ($command_name, $bot) {
            if (str_starts_with($json->d->content, $bot->prefix . $command_name)) {
                $this->execute($json->d, $bot);
            }
        });
    }

    /**
     * Execute
     *
     * @param stdClass $json
     * @param Bot $bot
     *
     */
    public abstract function execute($json, $bot);
}
