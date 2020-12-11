<?php

namespace Ourted\Model;

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
        /* GUILDS (1<<0) */
        $bot->addDispatch('GUILD_CREATE', function ($json) {
            $this->onGuildCreate($json->d, $this->bot);
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

        /* GUILD_MEMBERS (1<<0) */
        $bot->addDispatch('GUILD_MEMBER_ADD', function ($json) {
            $this->onGuildMemberAdd($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_MEMBER_UPDATE', function ($json) {
            $this->onGuildMemberUpdate($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_MEMBER_DELETE', function ($json) {
            $this->onGuildMemberDelete($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_MEMBER_DELETE', function ($json) {
            $this->onGuildMemberDelete($json->d, $this->bot);
        });
        /* GUILD_BANS (1<<2) */
        $bot->addDispatch('GUILD_BAN_ADD', function ($json) {
            $this->onGuildBanAdd($json->d, $this->bot);
        });
        $bot->addDispatch('GUILD_BAN_REMOVE', function ($json) {
            $this->onGuildBanRemove($json->d, $this->bot);
        });

        /* GUILD_EMOJIS (1<<3) */
        $bot->addDispatch('GUILD_EMOJIS_UPDATE', function ($json) {
            $this->onGuildEmojisUpdate($json->d, $this->bot);
        });

        /* GUILD_INTEGRATIONS (1<<4) */
        $bot->addDispatch('GUILD_INTEGRATIONS_UPDATE', function ($json) {
            $this->onGuildIntegrationsUpdate($json->d, $this->bot);
        });

        /* GUILD_WEBHOOKS (1<<5) */
        $bot->addDispatch('WEBHOOKS_UPDATE', function ($json) {
            $this->onWebhooksUpdate($json->d, $this->bot);
        });

        /* GUILD_INVITES (1<<6) */
        $bot->addDispatch('INVITE_CREATE', function ($json) {
            $this->onInviteCreate($json->d, $this->bot);
        });
        $bot->addDispatch('INVITE_DELETE', function ($json) {
            $this->onInviteDelete($json->d, $this->bot);
        });

        /* GUILD_VOICE_STATES (1<<7) */
        $bot->addDispatch('VOICE_STATE_UPDATE', function ($json) {
            $this->onVoiceStateUpdate($json->d, $this->bot);
        });

        /* GUILD_PRESENCES (1<<8) */
        $bot->addDispatch('PRESENCE_UPDATE', function ($json) {
            $this->onPresenceUpdate($json->d, $this->bot);
        });

        /* GUILD_MESSAGES (1<<9) */
        $bot->addDispatch('MESSAGE_CREATE', function ($json) {
            $this->onMessageCreate($json->d, $this->bot);
        });
        $bot->addDispatch('MESSAGE_UPDATE', function ($json) {
            $this->onMessageUpdate($json->d, $this->bot);
        });
        $bot->addDispatch('MESSAGE_DELETE', function ($json) {
            $this->onMessageDelete($json->d, $this->bot);
        });
        $bot->addDispatch('MESSAGE_DELETE_BULK', function ($json) {
            $this->onMessageDeleteBulk($json->d, $this->bot);
        });

        /* GUILD_MESSAGE_REACTIONS (1<<10) */
        $bot->addDispatch('MESSAGE_REACTION_ADD', function ($json) {
            $this->onMessageReactionAdd($json->d, $this->bot);
        });
        $bot->addDispatch('MESSAGE_REACTION_REMOVE', function ($json) {
            $this->onMessageReactionRemove($json->d, $this->bot);
        });
        $bot->addDispatch('MESSAGE_REACTION_REMOVE_ALL', function ($json) {
            $this->onMessageReactionRemoveAll($json->d, $this->bot);
        });
        $bot->addDispatch('MESSAGE_REACTION_REMOVE_EMOJI', function ($json) {
            $this->onMessageReactionRemoveEmoji($json->d, $this->bot);
        });

        /* GUILD_MESSAGE_TYPING | DIRECT_MESSAGE_TYPING (1<<11) */
        $bot->addDispatch('TYPING_START', function ($json) {
            $this->onTypingStart($json->d, $this->bot);
        });

        $bot->addDispatch('READY', function ($json) {
            $this->onReady($json->d, $this->bot);
        });
    }

    /* GUILDS (1<<0) */

    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onGuildCreate($json, $bot)
    {

    }
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onGuildDelete($json, $bot)
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

    /* GUILD_MEMBERS (1<<0) */
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


    /* GUILD_BANS (1<<2) */
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onGuildBanAdd($json, $bot)
    {

    }
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onGuildBanRemove($json, $bot)
    {

    }

    /* GUILD_EMOJIS (1<<3) */
        /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onGuildEmojisUpdate($json, $bot)
    {

    }

    /* GUILD_INTEGRATIONS (1<<3) */
        /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onGuildIntegrationsUpdate($json, $bot)
    {

    }

    /* GUILD_WEBHOOKS (1 << 5) */
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onWebhooksUpdate($json, $bot)
    {

    }

    /* GUILD_INVITES (1 << 6) */
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onInviteCreate($json, $bot)
    {

    }
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onInviteDelete($json, $bot)
    {

    }

    /* GUILD_VOICE_STATES (1 << 7) */
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onVoiceStateUpdate($json, $bot)
    {

    }

    /* GUILD_PRESENCES (1 << 8) */
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onPresenceUpdate($json, $bot)
    {

    }

    /* GUILD_MESSAGES (1 << 9) */
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onMessageCreate($json, $bot)
    {

    }
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onMessageUpdate($json, $bot)
    {

    }
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onMessageDelete($json, $bot)
    {

    }
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onMessageDeleteBulk($json, $bot)
    {

    }

    /* -GUILD_MESSAGE_REACTIONS (1 << 10) */
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onMessageReactionAdd($json, $bot)
    {

    }
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onMessageReactionRemove($json, $bot)
    {

    }
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onMessageReactionRemoveAll($json, $bot)
    {

    }
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onMessageReactionRemoveEmoji($json, $bot)
    {

    }

    /* GUILD_MESSAGE_TYPING (1 << 11) */
    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onTypingStart($json, $bot)
    {

    }

    /**
     * @param mixed $json
     * @param Bot $bot
     */
    public function onReady($json, $bot)
    {

    }


}
