<?php

namespace Ourted\Command;

class Heartbeat extends \Ourted\Interfaces\Command
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
