<?php

namespace Ourted\Ops;

class Hello extends \Ourted\Interfaces\Op
{
    public function execute($json)
    {
        \Ourted\State::log('Execute: HELLO');

        $interval = ((int)$json->d->heartbeat_interval / 1000) - 2;

        $bot = $this->getBot();
        $bot->setInterval($interval);
        $bot->authorize();
    }
}
