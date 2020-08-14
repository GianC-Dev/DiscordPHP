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
        parent::__construct($this->token, '!');
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

class EventListener extends \Ourted\Interfaces\EventListener
{

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

    public function execute($message, $bot){
        $bot->channel->sendMessage("Command Used! Command: {$message->content}", $message->channel_id);
    }
}

new Ourted();
?>
```
Result:
---
![Example Command](assets/Command.PNG)

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
        foreach ($this->channel->getMessages($channel) as $key => $item) {
            if($key == 99){
                return;
            }
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


