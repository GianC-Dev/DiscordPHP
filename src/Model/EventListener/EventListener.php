<?php

namespace Ourted\Model\EventListener;

use Ourted\Bot;

abstract class EventListener
{
    /**
     * Bot
     *
     * @var Bot $bot
     */
    public $bot;


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
        $bot->addDispatch('GUILD_CREATE', function ($json) {
            $this->onGuildJoin($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_MEMBER_ADD', function ($json) {
            $this->onGuildMemberAdd($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_MEMBER_UPDATE', function ($json) {
            $this->onGuildMemberUpdate($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_MEMBER_DELETE', function ($json) {
            $this->onGuildMemberDelete($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_UPDATE', function ($json) {
            $this->onGuildDelete($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_DELETE', function ($json) {
            $this->onGuildUpdate($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_ROLE_CREATE', function ($json) {
            $this->onGuildRoleCreate($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_ROLE_UPDATE', function ($json) {
            $this->onGuildRoleUpdate($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_ROLE_DELETE', function ($json) {
            $this->onGuildRoleDelete($json->d, $this->bot);
        });
        $bot->addDispatch('MESSAGE_CREATE', function ($json) {
            $this->onMessageCreate($json->d, $this->bot);
        });
        $bot->addDispatch('CHANNEL_CREATE', function ($json) {
            $this->onChannelCreate($json->d, $this->bot);
        });
        $bot->addDispatch('CHANNEL_UPDATE', function ($json) {
            $this->onChannelUpdate($json->d, $this->bot);
        });
        $bot->addDispatch('CHANNEL_DELETE', function ($json) {
            $this->onChannelDelete($json->d, $this->bot);
        });
        $bot->addDispatch('CHANNEL_PINS_UPDATE', function ($json) {
            $this->onChannelPinsUpdate($json->d, $this->bot);
        });

        $bot->addDispatch('READY', function ($json) {
            $this->onReady($json->d, $this->bot);
        });
    }

    # Guild
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onGuildJoin($json, $bot)
    {

    }

    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onGuildUpdate($json, $bot)
    {

    }

    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onGuildDelete($json, $bot)
    {

    }

    # Member
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onGuildMemberAdd($json, $bot)
    {

    }

    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onGuildMemberUpdate($json, $bot)
    {

    }

    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onGuildMemberDelete($json, $bot)
    {

    }

    # Channel
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onChannelCreate($json, $bot)
    {

    }

    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onChannelUpdate($json, $bot)
    {

    }

    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onChannelDelete($json, $bot)
    {

    }

    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onChannelPinsUpdate($json, $bot)
    {

    }

    # Role
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onGuildRoleCreate($json, $bot)
    {

    }

    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onGuildRoleUpdate($json, $bot)
    {

    }

    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onGuildRoleDelete($json, $bot)
    {

    }

    # Message
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onMessageCreate($json, $bot)
    {

    }

    # Bot
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onReady($json, $bot)
    {

    }


}
