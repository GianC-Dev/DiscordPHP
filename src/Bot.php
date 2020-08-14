<?php

namespace Ourted;

use Closure;
use Exception;
use Ourted\Interfaces\Channel;
use Ourted\Interfaces\Guild;
use Ourted\Interfaces\User;
use Ourted\Utils\API;
use Ratchet\Client\Connector;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\Factory;
use Ourted\Utils\Settings;

class Bot
{
    /**
     * Default WSS URL (from the Discord API docs)
     * @var string
     */
    protected $wssUrl = 'wss://gateway.discord.gg/?v=6&encoding=json';

    /**
     * State
     * @var State
     */
    public $state;

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
     * Commands
     * @var [type]
     */
    protected $commands = [];

    /**
     * Listeners
     */
    protected $listeners = [];

    public $loop;

    /**
     * @var string
     */
    public $prefix;

    /**
     * @var bool
     */
    public $send_log = false;


    /* Classes */

    /** @var API */
    public $api;

    /** @var Channel */
    public $channel;

    /** @var Guild */
    public $guild;

    /** @var User */
    public $user;

    /* Finish Classes */

    /**
     * Add a new dispatch handler
     *
     * @param string $type Dispatch type
     * @param string $callback_name Dispatch name
     * @param string|Callable $callback Callback to execute when dispatching action
     */
    public function addDispatch($type, $callback_name, $callback)
    {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-*."é~,;<>';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 40; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $this->dispatch[$type][$randomString] = $callback;
    }

    /**
     * Add a new command
     *
     * @param closure $function Command Function
     * @param string $command_name Command Name
     */
    public function addCommand($command_name, $function)
    {
        $function($this, $command_name);
    }

    /**
     * Set Bot
     *
     * @param string $botToken Current bot token
     * @param string $botPrefix Bot Prefix
     * @param string $wssUrl WSS URL [optional]
     */

    public function __construct($botToken, $botPrefix, $wssUrl = null)
    {
        if ($wssUrl !== null) {
            $this->wssUrl = $wssUrl;
        }
        $this->prefix = $botPrefix;
        $this->token = $botToken;
        $this->settings = new Settings($this);
        $this->channel = new Channel($this);
        $this->guild = new Guild($this);
        $this->user = new User($this);
        $this->api = new API($this);

        $this->loop = Factory::create();
        $this->init();
    }

    /**
     * Add a new dispatch handler
     *
     * @param string ...$listener
     */
    public function addListeners(...$listener)
    {
        foreach ($listener as $item) {
            $this->listeners[] = $item;
            new $item($this);
        }
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
            $this->state = $state  = new State($conn, $this->loop, $this->token);
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
