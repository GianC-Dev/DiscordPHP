## Ourted: A Discord bot in PHP

The `Ourted` library provides a running bot process written in PHP.

### Installation

```
composer require ourted/ourted
```

Edit ``.env`` and configure bot token

### Examples
Without Event Listener
```php
<?php

require_once __DIR__ . '\\vendor\\autoload.php';

use Dotenv\Dotenv;
use Ourted\Bot;

class Ourted extends Bot
{

    public $token;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        $this->token = $_ENV['BOT_TOKEN'];
        parent::__construct($this->token);
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
![Example](assets/Hello.PNG)


---
With Event Listener

```php
<?php

require_once __DIR__ . '\\vendor\\autoload.php';

use Dotenv\Dotenv;
use Ourted\Bot;

class Ourted extends Bot
{

    public $token;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        $this->token = $_ENV['BOT_TOKEN'];
        parent::__construct($this->token);
        $this->setBot();
    }

    public function setBot()
    {
        // Ready Event Listener
        $this->addListener(
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
        $this->func->sendMessage("Message Sended! By: <@{$json->author->id}>, Content: {$json->content}", $json->channel_id);
    }


}

new Ourted();
?>
```
Result:
![Example With Event Listener](assets/Event_Listener.PNG)
