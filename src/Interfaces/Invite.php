<?php

namespace Ourted\Interfaces;

use Ourted\Bot;

class Invite{

    /** @var Bot */
    private $bot;

    public function __construct($bot)
    {
        $this->bot = $bot;
    }

    /**
     *
     * @param int|string $invite_code
     * @return mixed
     */
    public function getInvite($invite_code){
        return new \Ourted\Model\Invite\Invite($this->bot, $invite_code);
    }
}