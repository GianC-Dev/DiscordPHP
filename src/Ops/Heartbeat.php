<?php

namespace Ourted\Ops;

class Heartbeat extends \Ourted\Model\Op\Op
{
    public function execute($json)
    {
        $this->bot->send_log ?
        \Ourted\State::log('Execute: HEARTBEAT') : null;

        $json = json_encode([
            'op' => 1,
            'd' => 1
        ]);

        $this->getConnection()->send($json);
    }
}
