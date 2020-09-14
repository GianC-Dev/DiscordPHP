<?php

namespace Ourted\Interfaces;

class Types
{
    public function permissions()
    {
        static $CREATE_INSTANT_INVITE = 0x00000001;
        static $KICK_MEMBERS = 0x00000002;
        static $BAN_MEMBERS = 0x00000004;
        static $ADMINISTRATOR = 0x00000008;
        static $MANAGE_CHANNELS = 0x00000010;
        static $MANAGE_GUILD = 0x00000020;
        static $ADD_REACTIONS = 0x00000040;
        static $VIEW_AUDIT_LOG = 0x00000080;
        static $PRIORITY_SPEAKER = 0x00000100;
        static $STREAM = 0x00000200;
        static $VIEW_CHANNEL = 0x00000400;
        static $SEND_MESSAGES = 0x00000800;
        static $SEND_TTS_MESSAGES = 0x00001000;
        static $MANAGE_MESSAGES = 0x00002000;
        static $EMBED_LINKS = 0x00004000;
        static $ATTACH_FILES = 0x00008000;
        static $READ_MESSAGE_HISTORY = 0x00010000;
        static $MENTION_EVERYONE = 0x00020000;
        static $USE_EXTERNAL_EMOJIS = 0x00040000;
        static $VIEW_GUILD_INSIGHTS = 0x00080000;
        static $CONNECT = 0x00100000;
        static $SPEAK = 0x00200000;
        static $MUTE_MEMBERS = 0x00400000;
        static $DEAFEN_MEMBERS = 0x00800000;
        static $MOVE_MEMBERS = 0x01000000;
        static $USE_VAD = 0x02000000;
        static $CHANGE_NICKNAME = 0x04000000;
        static $MANAGE_NICKNAMES = 0x08000000;
        static $MANAGE_ROLES = 0x10000000;
        static $MANAGE_WEBHOOKS = 0x20000000;
        static $MANAGE_EMOJIS = 0x40000000;
    }

    public function textChannel()
    {
        static $GUILD_TEXT = 0;
        static $DM = 1;
        static $GUILD_VOICE = 2;
        static $GROUP_DM = 3;
        static $GUILD_NEWS = 4;
        static $GUILD_STORE = 5;
    }



}