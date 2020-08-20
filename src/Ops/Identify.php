<?php

namespace Ourted\Ops;

use Ourted\Model\Op\Op;
use Ourted\State;

class Identify extends Op
{
    public function execute($json)
    {
        $this->bot->send_log ?
            State::log('Execute: IDENTIFY') : null;

        $json = json_encode([
                'op' => 2,
                'd' => [
                    'token' => $this->getBot()->getToken(),
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
}
