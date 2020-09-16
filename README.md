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
 # Guild
    public function onGuildCreate($json, $bot)
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

    #Message

    public function onMessageCreate($json, $bot)
    {
        /* 
        Content: $json->content
        Author Username: $json->author->username
        Author Discriminator: $json->author->discriminator
        Author ID: $json->author->id
        */

        if(isset($json->author->bot)){
            return;
        }
        $this->channel->sendMessage("Message Sent! By: <@{$json->author->id}>, Content: {$json->content}", $json->channel_id);
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


