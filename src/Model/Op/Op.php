<?php

namespace Ourted\Model\Op;

use Ourted\Bot;
use Ratchet\Client\WebSocket;
use React\EventLoop\ExtEventLoop;

abstract class Op
{
    /**
     * Current bot instance
     * @var Bot
     */
    protected $bot;

    /**
     * Curernt loop instance
     * @var ExtEventLoop
     */
    protected $loop;

    /**
     * Init the instance and set the bot and loop instance
     *
     * @param Bot $bot Bot instance
     * @param ExtEventLoop $loop EventLoop instance
     */
    public function __construct(&$bot, &$loop)
    {
        $this->bot = $bot;
        $this->loop = $loop;
    }

    /**
     * Get the current bot instance
     *
     * @return Bot instance
     */
    public function getBot()
    {
        return $this->bot;
    }

    /**
     * Get the current event loop instance
     *
     * @return ExtEventLoop instance
     */
    public function getLoop()
    {
        return $this->loop;
    }

    /**
     * Get the current connection from the Bot
     *
     * @return WebSocket
     */
    public function getConnection()
    {
        return $this->getBot()->getConnection();
    }

    /**
     * Abstract method definition for child class actions
     *
     * @var object $json JSON object
     */
    public abstract function execute($json);
}