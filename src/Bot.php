<?php

namespace Ourted;

use Exception;
use Ratchet\Client\Connector;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\Factory;
use Ourted\Utils\Functions;
use Ourted\Utils\Settings;

//use Ourted\Functions;

class Bot
{
    /**
     * Default WSS URL (from the Discord API docs)
     * @var string
     */
    protected $wssUrl = 'wss://gateway.discord.gg/?v=6&encoding=json';

    /**
     * Current bot token
     * @var string
     */
    public $token;

    /**
     * Interval
     * @var [type]
     */
    protected $interval = [];

    /**
     * Current set of dispatch handlers
     * @var [type]
     */
    protected $dispatch = [];

    public $loop;

    /**
     * Add a new dispatch handler
     *
     * @param string $type Dispatch type
     * @param string|Callable $callback Callback to execute when dispatching action
     */
    public function addDispatch($type, $callback)
    {
        $this->dispatch[$type] = $callback;
    }


    /**
     * Init the bot and set up the loop/actions for the WebSocket
     *
     * @param string $botToken Current bot token
     * @param string $wssUrl WSS URL [optional]
     */
    public function init($botToken, $wssUrl = null)
    {
        if ($wssUrl !== null) {
            $this->wssUrl = $wssUrl;
        }
        $this->token = $botToken;

        $this->loop = Factory::create();
        $reactConnector = new \React\Socket\Connector($this->loop);
        $connector = new Connector($this->loop, $reactConnector);
        $connector($this->wssUrl)->then(function (WebSocket $conn) {

                $state = new State($conn, $this->token, $this->loop);
                $state->addDispatch($this->dispatch);

                $conn->on('message', function (MessageInterface $msg) use ($conn, $state) {
                    $json = json_decode($msg);
                    $state->action($json, $this->loop);
                });

                $conn->on('close', function ($code = null, $reason = null) {
                    echo "Connection closed ({$code} - {$reason})\n";
                    die();
                });
            }, function (Exception $e) {
                echo "Could not connect: {$e->getMessage()}\n";
                $this->stop();
            });
        return null;
    }

    public function getFunctions(){
        return new Functions($this);
    }

    public function getSettings(){
        return new Settings($this);
    }

    public function run()
    {
        $this->loop->run();
    }

    public function stop(){
        $this->loop->stop();
    }


    /**
     * Get Connection
     *
     * @return WebSocket
     */
    public function getConnection()
    {
        $loop = Factory::create();
        $reactConnector = new \React\Socket\Connector($loop);
        $connector = new Connector($loop, $reactConnector);

        $connector($this->wssUrl)->then(function (WebSocket $conn) {
            return $conn;
        });
        return null;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getBot()
    {
        return $this;
    }


}
