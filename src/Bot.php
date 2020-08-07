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
     * Functions
     * @var Functions Instance
     */
    public $functions;

    /**
     * Current Connection
     * @var WebSocket Instance
     */
    protected $connection;

    /**
     * Functions
     * @var Settings Instance
     */
    public $settings;

    /**
     * Current bot token
     * @var mixed
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

    /**
     * Listeners
     */
    protected $listeners = [];

    public $loop;

    /**
     * Add a new dispatch handler
     *
     * @param string $type Dispatch type
     * @param string|Callable $callback Callback to execute when dispatching action
     */
    public function addDispatch($type, $callback)
    {
        $this->dispatch[$type][$type] = $callback;
    }

    /**
     * Set Bot
     *
     * @param string $botToken Current bot token
     * @param string $wssUrl WSS URL [optional]
     */

    public function __construct($botToken, $wssUrl = null)
    {
        if ($wssUrl !== null) {
            $this->wssUrl = $wssUrl;
        }
        $this->token = $botToken;
        $this->functions = new Functions($this);
        $this->settings = new Settings($this);
        $this->loop = Factory::create();
        $this->init();
    }

    /**
     * Add a new dispatch handler
     *
     * @param string $listener
     */
    public function addListener($listener)
    {
        $this->listeners[] = $listener;
        new $listener($this->getBot());
    }


    /**
     * Init the bot and set up the loop/actions for the WebSocket
     */
    public function init()
    {
        $reactConnector = new \React\Socket\Connector($this->loop);
        $connector = new Connector($this->loop, $reactConnector);
        $connector($this->wssUrl)->then(function (WebSocket $conn) {
            $this->connection = $conn;
            $state = new State($conn, $this->loop, $this->token);
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

    public function run()
    {
        $this->loop->run();
    }

    public function stop()
    {
        $this->loop->stop();
    }

    /**
     * Get Connection
     *
     * @return WebSocket
     */
    public function getConnection()
    {
        return $this->connection;
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
