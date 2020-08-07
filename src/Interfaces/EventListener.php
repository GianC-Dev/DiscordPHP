<?php

namespace Ourted\Interfaces;

use Ourted\Bot;
use Ourted\Utils\Functions;

class EventListener
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
        $this->func = $bot->functions;
        $bot->addDispatch('GUILD_CREATE','GUILD_CREATE', function ($json) {
            $this->onGuildJoin($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_MEMBER_ADD','GUILD_MEMBER_ADD', function ($json) {
            $this->onGuildMemberAdd($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_MEMBER_UPDATE','GUILD_MEMBER_UPDATE', function ($json) {
            $this->onGuildMemberUpdate($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_MEMBER_DELETE','GUILD_MEMBER_DELETE', function ($json) {
            $this->onGuildMemberDelete($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_UPDATE','GUILD_UPDATE', function ($json) {
            $this->onGuildDelete($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_DELETE','GUILD_DELETE', function ($json) {
            $this->onGuildUpdate($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_ROLE_CREATE','GUILD_ROLE_CREATE', function ($json) {
            $this->onGuildRoleCreate($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_ROLE_UPDATE','GUILD_ROLE_UPDATE', function ($json) {
            $this->onGuildRoleUpdate($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_ROLE_DELETE','GUILD_ROLE_DELETE', function ($json) {
            $this->onGuildRoleDelete($json->d, $this->bot);
        });
        $bot->addDispatch('MESSAGE_CREATE','MESSAGE_CREATEee', function ($json) {
            $this->onMessageCreate($json->d, $this->bot);
        });
        $bot->addDispatch('MESSAGE_CREATE','COMMANDS', function ($json) {
            $this->onCommand($json->d, $this->bot);
        });
        $bot->addDispatch('CHANNEL_CREATE','CHANNEL_CREATE', function ($json) {
            $this->onChannelCreate($json->d, $this->bot);
        });
        $bot->addDispatch('CHANNEL_UPDATE','CHANNEL_UPDATE', function ($json) {
            $this->onChannelUpdate($json->d, $this->bot);
        });
        $bot->addDispatch('CHANNEL_DELETE','CHANNEL_DELETE', function ($json) {
            $this->onChannelDelete($json->d, $this->bot);
        });
        $bot->addDispatch('CHANNEL_PINS_UPDATE','CHANNEL_PINS_UPDATE', function ($json) {
            $this->onChannelPinsUpdate($json->d, $this->bot);
        });

        $bot->addDispatch('READY','READY', function ($json) {
            $this->onReady($json->d, $this->bot);
        });
    }

    # Guild
    public function onGuildJoin($json, $bot)
    {

    }

    public function onGuildUpdate($json, $bot)
    {

    }

    public function onGuildDelete($json, $bot)
    {

    }

    # Member
    public function onGuildMemberAdd($json, $bot)
    {

    }

    public function onGuildMemberUpdate($json, $bot)
    {

    }

    public function onGuildMemberDelete($json, $bot)
    {

    }

    # Channel
    public function onChannelCreate($json, $bot)
    {

    }

    public function onChannelUpdate($json, $bot)
    {

    }

    public function onChannelDelete($json, $bot)
    {

    }

    public function onChannelPinsUpdate($json, $bot)
    {

    }






    # Role
    public function onGuildRoleCreate($json, $bot)
    {

    }

    public function onGuildRoleUpdate($json, $bot)
    {

    }

    public function onGuildRoleDelete($json, $bot)
    {

    }


    # Message
    public function onMessageCreate($json, $bot)
    {

    }

    # Command
    public function onCommand($json, $bot)
    {

    }

    # Bot
    public function onReady($json, $bot)
    {

    }


}
