<?php

namespace Ourted\Ops;

use Ourted\Model\Op\Op;
use Ourted\State;

class Heartbeatack extends Op
{
    public function execute($json)
    {
        $this->bot->send_log ?
            State::log('Execute: HEARTBEAT-ACK') : null;
    }
}
