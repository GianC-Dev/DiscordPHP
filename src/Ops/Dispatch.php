<?php

namespace Ourted\Ops;

class Dispatch extends \Ourted\Model\Op\Op
{
    public function execute($json)
    {
        \Ourted\State::log('Execute: DISPATCH');

        $bot = parent::getBot();
        $loop = $this->getLoop();
        $type = $json->t;

        \Ourted\State::log('Dispatch type: '.$type);
        $this->getLoop()->addPeriodicTimer($bot->getInterval(), function() use ($bot, $loop){
            $command = new \Ourted\Ops\Heartbeat($bot, $loop);
            $command->execute(null);
        });

        $bot->dispatch($type, $json);
    }
}
