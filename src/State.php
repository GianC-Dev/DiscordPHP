<?php

namespace Ourted;

use Closure;
use Ourted\Ops\Identify;
use Ratchet\Client\WebSocket;
use React\EventLoop\ExtEventLoop;

class State
{
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
     * Loop instance
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
        1 => 'Hello',
        2 => 'Identify',
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
     * Status constants
     * @var string
     */
    const STATUS_DISCONNECTED = 'disconnected';
    const STATUS_CONNECTED = 'connected';
    const STATUS_AUTHED = 'authorized';

    /**
     * Init the State handler and set the connection, token and loop properties
     *
     * @param WebSocket $conn Connection instance
     * @param ExtEventLoop $loop  Loop instance
     * @param mixed $token Current Bot Token
     */
    public function __construct($conn, $loop, $token)
    {
        $this->connection = $conn;
        $this->token = $token;
        $this->loop = $loop;
    }

    /**
     * Logging output method
     *
     * @param string $message Message to output
     */
    public static function log($message)
    {
        echo '['.date('Y-m-d H:i:s').'] '. $message."\n";
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
     * Get the current token value
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
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
     * @param $loop
     */
    public function action($json, $loop)
    {
        //State::log('Incoming: '.print_r($json, true));

        $op = $json->op;

        $commandNs = '\\Ourted\\Ops\\'.$this->ops[$op];
        $command = new $commandNs($this, $loop);
        $command->execute($json);
    }

    /**
     * Authorize the bot and update its state
     */
    public function authorize()
    {
        $loop = $this->getLoop();

        /** @noinspection PhpParamsInspection */
        $command = new Identify($this, $loop);
        $command->execute(null);

        $this->status = self::STATUS_AUTHED;
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

    /**
     * Dispatch the action (command) based on the type
     *
     * @param string $type Type of action
     * @param object $json JSON object
     * @return mixed
     */
    public function dispatch($type, $json)
    {
        if(!empty($this->dispatch[$type]) && isset($this->dispatch[$type])){
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
}
