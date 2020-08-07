<?php

namespace Ourted\Ops;

class Identify extends \Ourted\Interfaces\Op
{
    public function execute($json)
    {
        \Ourted\State::log('Execute: IDENTIFY');

        $json = json_encode([
            'op' => 2,
            'd' => [
                'v' => 3,
                'token' => $this->getBot()->getToken(),
                'properties' => [
                    '$os' => 'MacOS',
                    '$browser' => 'TestBrowse',
                    '$device' => 'MyCon',
                    '$referrer' => '',
                    '$referring_domain' => '',
                ],
                'compress' => false,
                'shard' => [0,1],
                'large_threshold' => 250,
                'presence' => [
                    'status' => 'online',
                    'afk' => false,
                    'since' => (time() - 60)
                ]
            ]
        ]);

        return $this->getConnection()->send($json);
    }
}
