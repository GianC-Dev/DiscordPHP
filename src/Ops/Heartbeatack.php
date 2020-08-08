<?php

namespace Ourted\Ops;

class Heartbeatack extends \Ourted\Model\Op\Op
{
    public function execute($json)
    {
        \Ourted\State::log('Execute: HEARTBEAT-ACK');
        // Nothing to see...
    }
}
