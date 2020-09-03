<?php

namespace Ourted;

use Closure;
use Exception;
use Ourted\Interfaces\Channel;
use Ourted\Interfaces\Guild;
use Ourted\Interfaces\Invite;
use Ourted\Interfaces\Member;
use Ourted\Interfaces\User;
use Ourted\Model\Message\Embed;
use Ourted\Utils\API;
use Ourted\Utils\Settings;
use Ratchet\Client\Connector;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\Factory;

class Bot
{

    static $GUILD_TEXT = 0;
    static $DM = 1;
    static $GUILD_VOICE = 2;
    static $GROUP_DM = 3;
    static $GUILD_NEWS = 4;
    static $GUILD_STORE = 5;




    /**
     * State
     * @var State
     */
    public $state;
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
    public $loop;
    /**
     * @var string
     */
    public $prefix;
    /**
     * @var bool
     */
    public $send_log = false;
    /** @var API */
    public $api;
    /** @var Channel */
    public $channel;
    /** @var Guild */
    public $guild;
    /** @var User */
    public $user;
    /** @var Member */
    public $member;
    /** @var Invite */
    public $invite;
    /**
     * Default WSS URL (from the Discord API docs)
     * @var string
     */
    protected $wssUrl = 'wss://gateway.discord.gg/?v=6&encoding=json';
    /**
     * Current Connection
     * @var WebSocket Instance
     */
    protected $connection;


    /* Classes */
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

    /* Finish Classes */

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
        $this->member = new Member($this);
        $this->invite = new Invite($this);
        $this->guild = new Guild($this);
        $this->user = new User($this);
        $this->api = new API($this);

        $this->loop = Factory::create();
        $this->init();
    }

    /**
     * Init the bot and set up the loop/actions for the WebSocket
     */
    public function init()
    {
        $connector = new Connector($this->loop, new \React\Socket\Connector($this->loop));
        $connector($this->wssUrl)->then(function (WebSocket $conn) {
            $this->connection = $conn;
            $this->state = $state = new State($conn, $this->loop, $this->token);
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

    public function stop()
    {
        $this->loop->stop();
    }

    /**
     * Add a new dispatch handler
     *
     * @param string $type Dispatch type
     * @param string $callback_name Dispatch name
     * @param string|Callable $callback Callback to execute when dispatching action
     */
    public function addDispatch($type, $callback)
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
     * @param $title
     * @param \Ourted\Model\Channel\Channel $channel
     * @param string $description
     */
    public function createEmbed($title, $channel, $description = "")
    {
        return new Embed($title, $this, $channel, $description);
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

    public function run()
    {

        $this->loop->run();
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
