<?php

require_once __DIR__ . '\\..\\vendor\\autoload.php';

use Dotenv\Dotenv;
use Ourted\Bot;
use Ourted\Model\Message\Embed;
use Ourted\Interfaces\Command;

class Ourted extends Bot
{
    public $token;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/');
        $dotenv->load();
        $this->token = $_ENV['BOT_TOKEN'];
        parent::__construct($this->token, "!");
        $this->setBot();
    }

    public function setBot()
    {

        $func = $this->functions;
        $settings = $this->settings;

        // Ready Event Listener
        $this->addListener(
            "EventListener"
        );

        // Send Message
        $func->sendMessage("Test", "701838704095920198");


        // Change Bot Username
        $settings->change_bot_username("test_bot");


        /* Embed Start */
        $embed_array = array();
        $embed_string = "";
        foreach (json_decode($func->get_guilds_properties()) as $key => $server) {
            $embed_array[] = array("name" => "Server of {$key}.", "value" => $server->name);
            $embed_string .= " Server of {$key}: {$server->name} ";
        }


        // Without Embed
        $func->sendMessage("Family: " . $embed_string, "701838704095920198");


        // With Single Array
        $embed = new Embed("Single Array", parent::getBot(), "701838704095920198", "Family");
        $embed->add_field($embed_array);
        $embed->send_embed();


        // With Multiple Array
        $embed = new Embed("Multiple Array", parent::getBot(), "701838704095920198", "Family");
        $embed->add_field(array("name" => "Field 1", "value" => "Field 1 Value"), array("name" => "Field 2", "value" => "Field 2 Value"));
        $embed->send_embed();

        /* Embed End */

        // Command
        $this->addCommand("test_command", function ($bot, $command_name){
            new TestCommand($bot, $command_name);
        });


        // Change Error Reporting
        $settings->change_error_reporting(0);
        $settings->change_error_reporting(false);


        parent::run();

    }
}

class EventListener extends \Ourted\Interfaces\EventListener
{

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

    # Bot
    public function onReady($json, $bot)
    {

    }


}
class TestCommand extends Command{

    public function execute($json, $bot){
        $bot->functions->sendMessage("Command Used! Command: {$json->content}", $json->channel_id);
    }
}

new Ourted();
