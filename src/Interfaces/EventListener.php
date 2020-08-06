<?php

namespace Ourted\Interfaces;

use Ourted\Bot;
use Ourted\Utils\Functions;

abstract class EventListener
{
    /**
     * Bot
     *
     * @var Bot $bot
     */
    public $bot;

    /**
     * Bot
     *
     * @var Functions $bot
     */
    public $func;


    /**
     * Bot Token
     *
     * @var string $token
     */
    public $token;

    /**
     *
     * @var Bot $bot
     */
    public function __construct($bot)
    {
        $this->bot = $bot;
        $this->token = $bot->getToken();
        $this->func = $bot->getFunctions();
        $bot->addDispatch('GUILD_CREATE', function ($json) {
            $this->onGuildCreate($json);
        });
        $bot->addDispatch('GUILD_MEMBER_UPDATE', function ($json) {
            $this->onGuildMemberUpdate($json);
        });
        $bot->addDispatch('GUILD_UPDATE', function ($json) {
            $this->onGuildUpdate($json);
        });
        $bot->addDispatch('GUILD_DELETE', function ($json) {
            $this->onGuildUpdate($json);
        });
        $bot->addDispatch('GUILD_ROLE_CREATE', function ($json) {
            $this->onGuildRoleCreate($json);
        });
        $bot->addDispatch('GUILD_ROLE_UPDATE', function ($json) {
            $this->onGuildRoleUpdate($json);
        });
        $bot->addDispatch('MESSAGE_CREATE', function ($json) {
            $this->onMessageCreate($json);
        });
    }

    public abstract function onGuildCreate($json);
    public abstract function onGuildMemberUpdate($json);
    public abstract function onGuildUpdate($json);
    public abstract function onGuildDelete($json);
    public abstract function onGuildRoleCreate($json);
    public abstract function onGuildRoleUpdate($json);
    public abstract function onMessageCreate($json);





}
