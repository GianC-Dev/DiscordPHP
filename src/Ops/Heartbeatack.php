<?php

namespace Ourted\Ops;

class Heartbeatack extends \Ourted\Interfaces\Op
{
    public function execute($json)
    {
        \Ourted\State::log('Execute: HEARTBEAT-ACK');
        // Nothing to see...
    }
}
