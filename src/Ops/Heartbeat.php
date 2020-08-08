<?php

namespace Ourted\Ops;

class Heartbeat extends \Ourted\Model\Op\Op
{
    public function execute($json)
    {
        \Ourted\State::log('Execute: HEARTBEAT');

        $json = json_encode([
            'op' => 1,
            'd' => 1
        ]);

        $this->getConnection()->send($json);
    }
}
