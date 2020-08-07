<?php

namespace Ourted\Command;

class Dispatch extends \Ourted\Interfaces\Command
{
    public function execute($json)
    {
        \Ourted\State::log('Execute: DISPATCH');

        $bot = parent::getBot();
        $loop = $this->getLoop();
        $type = $json->t;

        \Ourted\State::log('Dispatch type: '.$type);
        $this->getLoop()->addPeriodicTimer($bot->getInterval(), function() use ($bot){
            $command = new \Ourted\Command\Heartbeat($bot, $loop);
            $command->execute(null);
        });

        $bot->dispatch($type, $json);
    }
}
