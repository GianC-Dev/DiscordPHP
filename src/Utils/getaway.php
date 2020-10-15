<?php

namespace Ourted\Utils;

use Closure;
use Ourted\Bot;
use Ratchet\Client\WebSocket;
use React\EventLoop\ExtEventLoop;

class getaway
{
    /**
     * Status constants
     * @var string
     */
    const STATUS_DISCONNECTED = 'disconnected';
    const STATUS_CONNECTED = 'connected';
    const STATUS_AUTHED = 'authorized';
    /**
     * @var bool
     */
    public $send_log = true;
    /**
     * The current connection instance
     * @var WebSocket
     */
    protected $connection;
    /**
     * Current bot token
     * @var string
     */
    protected $token;
    /**
     * Loop instance
     * @var ExtEventLoop
     */
    protected $loop;
    /**
     * Bot Instance
     * @var Bot
     */
    protected $bot;
    /**
     * Default heartbeat interval
     * @var integer
     */
    protected $interval = 5;

    /**
     * Discord API operations to class relationships
     * @var [type]
     */
    protected $ops = [
        0 => 'Dispatch',
        1 => 'Heartbeat',
        2 => 'Identify',
        3 => 'Presence',
        4 => 'Voice',
        6 => 'Resume',
        7 => 'Reconnect',
        8 => 'Request',
        9 => 'Invalid Session',
        10 => 'Hello',
        11 => 'Heartbeatack'
    ];


    /**
     * Current dispatch relationships
     * @var array
     */
    protected $dispatch = [];
    /**
     * Current bot status (used in identify)
     * @var string
     */
    protected $status = self::STATUS_DISCONNECTED;

    /**
     * Init the State handler and set the connection, token and loop properties
     *
     * @param WebSocket $conn Connection instance
     * @param ExtEventLoop $loop Loop instance
     * @param mixed $token Current Bot Token
     */
    public function __construct($conn, $loop, $token)
    {
        $this->connection = $conn;
        $this->token = $token;
        $this->loop = $loop;
    }

    /**
     * Get the current heartbeat interval
     *
     * @return int
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * Set the current heartbeat interval
     *
     * @param int $interval Interval in seconds
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;
    }

    /**
     * Determine the action (command) to be taken based on the JSON input
     *
     * @param object $json JSON object, parsed from API response
     */
    public function action($json)
    {
        $op = $this->ops[$json->op];

        if ($op == "Dispatch") {
            $this->send($json);
        }

        if ($op == "Heartbeatack") {
            $this->send_log ?
                $this->log('Execute: HEARTBEAT-ACK') : null;
        }

        if ($op == "Hello") {
           $this->hello($json);
        }

    }



    private function send($json){
        $this->send_log ?
            $this->log('Execute: DISPATCH') : null;
        $type = $json->t;
        $this->send_log ?
            $this->log('Dispatch type: ' . $type) : null;
        $this->dispatch($type, $json);
    }
    private function hello($json){
        $this->send_log ?
            $this->log('Execute: HELLO') : null;
        $interval = intval($json->d->heartbeat_interval) / 1000;
        $this->getLoop()->addPeriodicTimer($interval, function () {
            $this->keep_alive();
        });
        $this->setInterval($interval);
        $this->authorize();
    }
    private function identify(){
        $this->send_log ?
        $this->log('Execute: IDENTIFY') : null;
        $json = json_encode([
                'op' => 2,
                'd' => [
                    'token' => $this->getToken(),
                    'properties' => [
                        '$os' => 'linux',
                        '$browser' => 'Ourted',
                        '$device' => 'Ourted',
                    ],
                    'compress' => false,
                    'shard' => [0, 1],
                    'large_threshold' => 250,
                ]
            ]
        );
        return $this->getConnection()->send($json);
    }
    private function keep_alive(){
        $this->send_log ?
            $this->log('Execute: HEARTBEAT') : null;
        $json = json_encode([
            'op' => 1,
            'd' => 1
        ]);
        $this->getConnection()->send($json);
    }



    /**
     * Logging output method
     *
     * @param string $message Message to output
     */
    public static function log($message)
    {

        echo '[' . date('Y-m-d H:i:s') . '] ' . $message . "\n";
    }

    /**
     * Dispatch the action (command) based on the type
     *
     * @param string $type Type of action
     * @param object $json JSON object
     * @return mixed
     */
    public function dispatch($type, $json)
    {
        if (!empty($this->dispatch[$type]) && isset($this->dispatch[$type])) {
            $dis = $this->dispatch[$type];
            foreach ($dis as $key => $item) {
                if ($item instanceof Closure) {
                    $item($json);
                } elseif (is_callable($dis)) {
                    $obj = $item[0];
                    $obj->$item[1]($json);
                }
                continue;
            }
            return null;
        }
        return null;
    }

    /**
     * Get the current connection
     *
     * @return WebSocket instance
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Get the current event loop
     *
     * @return ExtEventLoop instance
     */
    public function getLoop()
    {
        return $this->loop;
    }

    /**
     * Authorize the bot and update its state
     */
    public function authorize()
    {
        $this->identify();

        $this->status = self::STATUS_AUTHED;
    }

    /**
     * Get the current token value
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Check the current state to see if the status is marked as authed (post-identify)
     *
     * @return boolean Authed/not authed status
     */
    public function isAuthed()
    {
        return ($this->status == self::STATUS_AUTHED);
    }

    /**
     * Set the dispatch array value
     *
     * @param array $dispatch Dispatch set
     */
    public function addDispatch(array $dispatch)
    {
        $this->dispatch = $dispatch;
    }
}
