<?php
namespace Ourted\Interfaces;

use Ourted\Bot;

class User{

    /** @var Bot */
    private $bot;

    public function __construct($bot)
    {
        $this->bot = $bot;
    }


    /**
     * Get User
     *
     * @param int|string $user_id
     * @return \Ourted\Model\User\User User Instance
     */

    public function getUser($user_id)
    {
        return new \Ourted\Model\User\User($this->bot, $user_id);
    }


}