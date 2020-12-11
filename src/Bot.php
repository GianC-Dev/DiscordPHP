<?php

namespace Ourted;

use Closure;
use Exception;
use Ourted\Interfaces\Channel;
use Ourted\Interfaces\Emoji;
use Ourted\Interfaces\Guild;
use Ourted\Interfaces\Invite;
use Ourted\Interfaces\Member;
use Ourted\Interfaces\Settings;
use Ourted\Interfaces\User;
use Ourted\Interfaces\Webhook;
use Ourted\Model\Channel\Embed;
use Ourted\Utils\getaway;
use Ourted\Utils\http;
use Ratchet\Client\Connector;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\Factory;

class Bot
{
    


    /**
     * Getaway
     * @var getaway
     */
    public $getaway;
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
    /** @var http */
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
    /** @var Webhook */
    public $webhook;
    /** @var Emoji */
    public $emoji;
    /**
     * @var mixed
     */
    public $session_id;
    /**
     * Default WSS URL (from the Discord API docs)
     * @var string
     */
    protected $wssUrl = 'wss://gateway.discord.gg/?v=8&encoding=json';
    /**
     * Current Connection
     * @var WebSocket Instance
     */
    protected $connection;
    /**
     * @var bool
     */
    protected $reconnect = false;


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
        $this->webhook = new Webhook($this);
        $this->channel = new Channel($this);
        $this->member = new Member($this);
        $this->invite = new Invite($this);
        $this->emoji = new Emoji($this);
        $this->guild = new Guild($this);
        $this->user = new User($this);
        $this->api = new http($this);

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
            $this->getaway = $getaway = new getaway($conn, $this->loop, $this->token);
            $this->getaway->send_log = $this->send_log;
            $getaway->addDispatch($this->dispatch);


            $conn->on('message', function (MessageInterface $msg) use ($conn, $getaway) {
                $json = json_decode($msg);
                if (isset($json->d->session_id)) {
                    $this->session_id = $json->d->session_id;
                }
                $getaway->action($json);
            });


            $conn->on('close', function ($code = null, $reason = null) use ($conn) {
                echo "\nConnection closed ({$code} ". $reason != null ? "- {$reason})\n" : "\n";
                if (!$this->reconnect) {
                    die();
                } else {
                    echo "We are begin of a rate limit, connect retrying after 60 seconds.";
                    $this->loop->addTimer(60, function () use ($conn) {
                        $conn->send(json_encode([
                            "op" => 6,
                            "d" => [
                                "token" => $this->getBot()->token,
                                "session_id" => $this->getBot()->session_id,
                                "seq" => 1337
                            ]
                        ]));});
                }
            });


        }, function (Exception $e) {
            echo "Could not connect: {$e->getMessage()}\n";
            $this->stop();
        });

        return null;
    }

    public function getBot()
    {
        return $this;
    }

    public function stop()
    {
        $this->loop->stop();
    }

    public function run()
    {

        $this->loop->run();
        echo "Connection Started!";
    }

    /**
     * Add a new dispatch handler
     *
     * @param string $type Dispatch type
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

    public function getImageData($image_path)
    {
        if (!file_exists($image_path) || str_ends_with($image_path, ("png" || "jpg" || "jpeg" | "PNG" || "JPG" || "JPEG"))) return "Fail";
        $imageData = base64_encode(file_get_contents($image_path));
        return 'data: ' . mime_content_type($image_path) . ';base64,' . $imageData;
    }

    /**
     * @param $title
     * @param Model\Channel\Channel $channel
     * @param string $description
     * @return Embed
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


}
