<?php
require_once __DIR__ . '/vendor/autoload.php';

use Ourted\Bot;
use Ourted\Model\Message\Embed;

class bot_ extends Bot
{
    public $token;

    public function __construct()
    {
        $this->token = "NzQwNjQyNDAyODg4NDUwMTQw.Xyr-_Q.Zkc2FWA5xUB3EtQqprwytSIzQss";
        parent::init($this->token);
        $this->setBot();
    }

    public function setBot()
    {

        $func = parent::getFunctions();
        $settings = parent::getSettings();


        // Ready Event Listener
        new EventListener($this->getBot());



        // Send Message
        $func->sendMessage("Test", "701838704095920198");




        // Change Bot Username
        $settings->change_bot_username("test_bot");




        /* Embed Start */
        $embed_array = array();
        $embed_string = "";
        foreach (json_decode($func->get_guilds_properties()) as $key => $server){
            $embed_array[] = array("name" => "Server of {$key}.", "value" => $server->name);
            $embed_string .= " Server of {$key}: {$server->name} ";
        }
        $func->sendMessage("Family: ".$embed_string, "701838704095920198");


        // With Single Array
        $embed = new Embed("Family", parent::getBot(), "701838704095920198", "Family");
        $embed->add_field( $embed_array);
        $embed->send_embed();


        // With Multiple Array
        $embed = new Embed("Family", parent::getBot(), "701838704095920198", "Family");
        $embed->add_field(array("name" => "ege", "value" => "FF"), array("name" => "eggge", "value" => "FgggF"));
        $embed->send_embed();




        /* Embed End */

        // Change Error Reporting
        $settings->change_error_reporting(0);
        $settings->change_error_reporting(false);



        parent::run();

    }
}
class EventListener extends \Ourted\Interfaces\EventListener
{

    public function __construct($bot)
    {
        parent::__construct($bot);
    }

    public function onGuildCreate($json)
    {
        // TODO: Implement onGuildCreate() method.
    }

    public function onGuildMemberUpdate($json)
    {
        // TODO: Implement onGuildMemberUpdate() method.


    }

    public function onGuildUpdate($json)
    {
        // TODO: Implement onGuildUpdate() method.
    }

    public function onGuildDelete($json)
    {
        // TODO: Implement onGuildDelete() method.
    }

    public function onGuildRoleCreate($json)
    {
        // TODO: Implement onGuildRoleCreate() method.
    }

    public function onGuildRoleUpdate($json)
    {
        // TODO: Implement onGuildRoleUpdate() method.
    }

    public function onMessageCreate($json)
    {
        /* Command Start */

        if($json->d->content == "??ping"){
            $this->func->sendMessage("Pong!", "701838704095920198");
        }

        /* Command End */
    }
}



new bot_();