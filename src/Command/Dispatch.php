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

        // Once we get our first dispatch, be sure we're sending a heartbeat
        $this->getLoop()->addPeriodicTimer($bot->getInterval(), function() use ($bot){
            // \Ourted\State::log('Execute: HELLO');
            $command = new \Ourted\Command\Heartbeat($bot, $loop);
            $command->execute(null);
        });

        // Dispatch the event
        $result = $bot->dispatch($type, $json);
        //var_export($result) ?? null;
    }
}
