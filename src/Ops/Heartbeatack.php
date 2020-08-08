<?php

namespace Ourted\Ops;

class Heartbeatack extends \Ourted\Model\Op\Op
{
    public function execute($json)
    {
        $this->bot->send_log ?
            \Ourted\State::log('Execute: HEARTBEAT-ACK') : null;
        // Nothing to see...
    }
}
