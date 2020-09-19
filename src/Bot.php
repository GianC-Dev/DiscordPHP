<?php

namespace Ourted;

use Closure;
use Exception;
use Ourted\Interfaces\Channel;
use Ourted\Interfaces\Guild;
use Ourted\Interfaces\Invite;
use Ourted\Interfaces\Member;
use Ourted\Interfaces\User;
use Ourted\Interfaces\Webhook;
use Ourted\Model\Channel\Embed;
use Ourted\Utils\getaway;
use Ourted\Utils\http;
use Ourted\Interfaces\Settings;
use Ratchet\Client\Connector;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\Factory;

class Bot
{


    public $PERMISSION_CREATE_INSTANT_INVITE = 0x00000001;
    public $PERMISSION_KICK_MEMBERS = 0x00000002;
    public $PERMISSION_BAN_MEMBERS = 0x00000004;
    public $PERMISSION_ADMINISTRATOR = 0x00000008;
    public $PERMISSION_MANAGE_CHANNELS = 0x00000010;
    public $PERMISSION_MANAGE_GUILD = 0x00000020;
    public $PERMISSION_ADD_REACTIONS = 0x00000040;
    public $PERMISSION_VIEW_AUDIT_LOG = 0x00000080;
    public $PERMISSION_PRIORITY_SPEAKER = 0x00000100;
    public $PERMISSION_STREAM = 0x00000200;
    public $PERMISSION_VIEW_CHANNEL = 0x00000400;
    public $PERMISSION_SEND_MESSAGES = 0x00000800;
    public $PERMISSION_SEND_TTS_MESSAGES = 0x00001000;
    public $PERMISSION_MANAGE_MESSAGES = 0x00002000;
    public $PERMISSION_EMBED_LINKS = 0x00004000;
    public $PERMISSION_ATTACH_FILES = 0x00008000;
    public $PERMISSION_READ_MESSAGE_HISTORY = 0x00010000;
    public $PERMISSION_MENTION_EVERYONE = 0x00020000;
    public $PERMISSION_USE_EXTERNAL_EMOJIS = 0x00040000;
    public $PERMISSION_VIEW_GUILD_INSIGHTS = 0x00080000;
    public $PERMISSION_CONNECT = 0x00100000;
    public $PERMISSION_SPEAK = 0x00200000;
    public $PERMISSION_MUTE_MEMBERS = 0x00400000;
    public $PERMISSION_DEAFEN_MEMBERS = 0x00800000;
    public $PERMISSION_MOVE_MEMBERS = 0x01000000;
    public $PERMISSION_USE_VAD = 0x02000000;
    public $PERMISSION_CHANGE_NICKNAME = 0x04000000;
    public $PERMISSION_MANAGE_NICKNAMES = 0x08000000;
    public $PERMISSION_MANAGE_ROLES = 0x10000000;
    public $PERMISSION_MANAGE_WEBHOOKS = 0x20000000;
    public $PERMISSION_MANAGE_EMOJIS = 0x40000000;

    public $CHANNEL_CHANNEL_GUILD_TEXT = 0;
    public $CHANNEL_DM = 1;
    public $CHANNEL_GUILD_VOICE = 2;
    public $CHANNEL_GROUP_DM = 3;
    public $CHANNEL_GUILD_NEWS = 4;
    public $CHANNEL_GUILD_STORE = 5;

    public $GAME_LISTEN = 2;
    public $GAME_WATCHING = 1;
    public $GAME_PLAYING = 0;


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
    /**
     * @var mixed
     */
    public $session_id;
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
                echo "\nConnection closed ({$code} - {$reason})\n";
                if (!$this->reconnect) {
                    die();
                } else {
                    $conn->send(json_encode([
                        "op" => 6,
                        "d" => [
                            "token" => $this->getBot()->token,
                            "session_id" => $this->getBot()->session_id,
                            "seq" => 1337
                        ]
                    ]));
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

    public function getImageData($image_path){
        if(!file_exists($image_path) || str_ends_with($image_path, ("png" || "jpg" || "jpeg" | "PNG" || "JPG" || "JPEG"))) return "Fail";
        $imageData = base64_encode(file_get_contents($image_path));
        return 'data: '.mime_content_type($image_path).';base64,'.$imageData;
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
