<?php

namespace Ourted\Ops;

class Dispatch extends \Ourted\Model\Op\Op
{
    public function execute($json)
    {
        $this->bot->send_log ?
            \Ourted\State::log('Execute: DISPATCH') : null;

        $bot = parent::getBot();
        $loop = $this->getLoop();
        $type = $json->t;
        $this->bot->send_log ?
            \Ourted\State::log('Dispatch type: ' . $type) : null;
        $this->getLoop()->addPeriodicTimer($bot->getInterval(), function () use ($bot, $loop) {
            $command = new \Ourted\Ops\Heartbeat($bot, $loop);
            $command->execute(null);
        });

        $bot->dispatch($type, $json);
    }
}
