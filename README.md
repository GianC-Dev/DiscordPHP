## Ourted: A Discord bot in PHP

The `Ourted` library provides a running bot process written in PHP.

### Installation

```
composer require ourted/ourted
```

Edit ``.env`` and configure bot token




Examples
---

#### More documents in example/Ourted.php


Without Event Listener
```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Ourted\Bot;

class Ourted extends Bot
{

    public $token;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $this->token = $_ENV['BOT_TOKEN'];
        parent::__construct($this->token, '!'); /* 1: Bot Token, 2: Bot Prefix */
        $this->setBot();
    }

    public function setBot()
    {
        echo "Hello World\n";
        $this->run();
    }
}

new Ourted();
?>
```

Result Log: 
---
![Example](assets/Hello.PNG)


---
With Event Listener

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Ourted\Bot;

class Ourted extends Bot
{

    public $token;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $this->token = $_ENV['BOT_TOKEN'];
        parent::__construct($this->token, "!");
        $this->setBot();
    }

    public function setBot()
    {
        // Ready Event Listener
        $this->addListeners(
            "EventListener"
        );
        echo "Hello World\n";
        $this->run();
    }
}

class EventListener extends \Ourted\Model\EventListener\EventListener
{

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
}

new Ourted();
?>
```
Result:
---
![Example With Event Listener](assets/Event_Listener.PNG)
---
Command
---
```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Ourted\Bot;

class Ourted extends Bot
{

    public $token;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $this->token = $_ENV['BOT_TOKEN'];
        parent::__construct($this->token, '!');
        $this->setBot();
    }

    public function setBot()
    {
        $this->addCommand("test_command", function ($bot, $command_name){
            new TestCommand($bot, $command_name);
        });
        $this->run();
    }
}
class TestCommand extends Command{

    public function execute($message, $bot, $channel, $guild){
        $bot->channel->sendMessage("Command Used! Command: {$message->content}", $channel);
    }
}

new Ourted();
?>
```
Result:
---
![Example Command](assets/Command.PNG)


addCommand() Parameters:
1. Command Name
2. a Closure to call command class

---

Delete Message
---

````php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Ourted\Bot;

class Ourted extends Bot
{

    public $token;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $this->token = $_ENV['BOT_TOKEN'];
        parent::__construct($this->token, '!');
        $this->setBot();
    }

    public function setBot()
    {


        // Get Channel
        $channel = $this->channel->getChannel(CHANNEL_ID);

        // Delete Messages
        $message = $this->channel->getMessage($channel, MESSAGE_ID);
        $this->channel->deleteMessage($message);


        $this->run();
    }
}

new Ourted();
?>
````

First wer get channel with getChannel() function. then delete messages with channel and message id.


Delete Bulk Message
---

````php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Ourted\Bot;

class Ourted extends Bot
{

    public $token;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $this->token = $_ENV['BOT_TOKEN'];
        parent::__construct($this->token, '!');
        $this->setBot();
    }

    public function setBot()
    {
        // Channel
        $channel = $this->channel->getChannel(CHANNEL_ID);

        $ids = "";
        // Count Messages
        foreach ($this->channel->getMessages($channel, 99) as $key => $item) {
            count($this->channel->getMessages($channel)) -1 == $key?
                $ids .= "\"$item->id\"" : $ids.= "\"$item->id\",";
        }
        // Delete Messages
        $this->channel->deleteBulkMessage("[{$ids}]", $channel);


        $this->run();
    }
}

new Ourted();
?>
````

On **getMessages()** Function must be 2 param setted 1-100 between, integer.

Paramaters:
1. Ourted\Model\Channel\Channel.php Instance
2. Integer 



Add Role
---

````php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Ourted\Bot;

class Ourted extends Bot
{

    public $token;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $this->token = $_ENV['BOT_TOKEN'];
        parent::__construct($this->token, '!');
        $this->setBot();
    }

    public function setBot()
    {
        // Channel
        $channel = $this->channel->getChannel(CHANNEL_ID);

    // Guild: $this->guild->getGuild(742361616728719373)
    // Name: "Test"
    // Color: 80 (blue)
    // Mentionable: true
    // hoist: true

        $this->guild->addRole($this->guild->getGuild(742361616728719373), "Test", 80, true, true);


        $this->run();
    }
}

new Ourted();
?>
````

Get Role
---

````php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Ourted\Bot;

class Ourted extends Bot
{

    public $token;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $this->token = $_ENV['BOT_TOKEN'];
        parent::__construct($this->token, '!');
        $this->setBot();
    }

    public function setBot()
    {
        // Channel
        $channel = $this->channel->getChannel(CHANNEL_ID);

    // ->id 
    // ->name
    // ->color
    // ->hoist
    // ->position
    // ->permissions
    // ->permissions_new
    // ->managed
    // ->mentionable

     echo $this->guild->getRole($this->guild->getGuild(742361616728719373), 742404691979272203)->name;



        $this->run();
    }
}

new Ourted();
?>
````


