<?php

namespace Ourted\Ops;

class Hello extends \Ourted\Model\Op\Op
{
    public function execute($json)
    {
        $this->bot->send_log ?
        \Ourted\State::log('Execute: HELLO'):null;

        $interval = ((int)$json->d->heartbeat_interval / 1000) - 2;

        $bot = $this->getBot();
        $bot->setInterval($interval);
        $bot->authorize();
    }
}
