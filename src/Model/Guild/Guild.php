<?php

namespace Ourted\Model\Guild;

use Ourted\Bot;

class Guild
{

    public $id;
    public $name;
    public $icon;
    public $description;
    public $splash;
    public $discovery_splash;
    public $approximate_member_count;
    public $approximate_presence_count;
    public $features;
    public $emojis;
    public $banner;
    public $owner_id;
    public $application_id;
    public $region;
    public $afk_channel_id;
    public $afk_timeout;
    public $system_channel_id;
    public $widget_enabled;
    public $widget_channel_id;
    public $verification_level;
    public $roles;
    public $default_message_notifications;
    public $mfa_level;
    public $explicit_content_filter;
    public $max_presences;
    public $max_members;
    public $max_video_channel_users;
    public $vanity_url_code;
    public $premium_tier;
    public $premium_subscription_count;
    public $system_channel_flags;
    public $preferred_locale;
    public $rules_channel_id;
    public $public_updates_channel_id;
    public $embed_enabled;
    public $embed_channel_id;
    
    /**
     * @param Bot $bot
     * @param int|string $guild_id
     */
    public function __construct($bot, $guild_id)
    {
        $json = json_decode($bot->api->send("guilds/{$guild_id}", "", "GET"));
        $this->id = $json->id ?? null;
        $this->name = $json->name ?? null;
        $this->icon = $json->icon ?? null;
        $this->description = $json->description ?? null;
        $this->splash = $json->splash ?? null;
        $this->discovery_splash = $json->discovery_splash ?? null;
        $this->approximate_member_count = $json->approximate_member_count ?? null;
        $this->approximate_presence_count = $json->approximate_presence_count ?? null;
        $this->features = $json->features ?? null;
        $this->emojis = $json->emojis ?? null;
        $this->banner = $json->banner ?? null;
        $this->owner_id = $json->owner_id ?? null;
        $this->application_id = $json->application_id ?? null;
        $this->region = $json->region ?? null;
        $this->afk_channel_id = $json->afk_channel_id ?? null;
        $this->afk_timeout = $json->afk_timeout ?? null;
        $this->system_channel_id = $json->system_channel_id ?? null;
        $this->widget_enabled = $json->widget_enabled ?? null;
        $this->widget_channel_id = $json->widget_channel_id ?? null;
        $this->verification_level = $json->verification_level ?? null;
        $this->roles = $json->roles ?? null;
        $this->default_message_notifications = $json->default_message_notifications ?? null;
        $this->mfa_level = $json->mfa_level ?? null;
        $this->explicit_content_filter = $json->explicit_content_filter ?? null;
        $this->max_presences = $json->max_presences ?? null;
        $this->max_members = $json->max_members ?? null;
        $this->max_video_channel_users = $json->max_video_channel_users ?? null;
        $this->vanity_url_code = $json->vanity_url_code ?? null;
        $this->premium_tier = $json->premium_tier ?? null;
        $this->premium_subscription_count = $json->premium_subscription_count ?? null;
        $this->system_channel_flags = $json->system_channel_flags ?? null;
        $this->preferred_locale = $json->preferred_locale ?? null;
        $this->rules_channel_id = $json->rules_channel_id ?? null;
        $this->public_updates_channel_id = $json->public_updates_channel_id ?? null;
        $this->embed_enabled = $json->embed_enabled ?? null;
        $this->embed_channel_id = $json->embed_channel_id ?? null;
        return $this;
    }
}