<?php

namespace Ourted\Command;

class Hello extends \Ourted\Interfaces\Command
{
    public function execute($json)
    {
        \Ourted\State::log('Execute: HELLO');

        $interval = ((int)$json->d->heartbeat_interval / 1000) - 2;

        $bot = $this->getBot();
        $bot->setInterval($interval, function (){
            echo "ege";
        });
        $bot->authorize();
    }
}
