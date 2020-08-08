<?php



use Dotenv\Dotenv;
use Ourted\Bot;
use Ourted\Model\Message\Embed;

class Ourted extends Bot
{
    public $token;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        $this->token = $_ENV['BOT_TOKEN'];
        parent::__construct($this->token, "!");
        $this->setBot();
    }

    public function setBot()
    {

        $settings = $this->settings;

        // Ready Event Listeners
        $this->addListeners(
            "EventListener"
        );

        // Channel
        $channel = $this->channel->getChannel("701838704095920198");

        // Delete Messages
        $message = $this->channel->getMessage($channel, 741581191009796128);
        $this->channel->deleteMessage($message);

        // Send Message
        $this->channel->sendMessage("Test", $channel);


        // Change Bot Username
        $settings->change_bot_username("test_bot");

        /* Embed Start */
        $embed_array = array();
        $embed_string = "";
        foreach (json_decode($this->guild->get_guilds_properties()) as $key => $server) {
            $embed_array[] = array("name" => "Server of {$key}.", "value" => $server->name);
            $embed_string .= " Server of {$key}: {$server->name} ";
        }


        // Without Embed
        $this->channel->sendMessage("Family: " . $embed_string, $channel);


        // With Single Array
        $embed = new Embed("Family", parent::getBot(), "701838704095920198", "Family");
        $embed->add_field($embed_array);
        $embed->send_embed();


        // With Multiple Array
        $embed = new Embed("Family", parent::getBot(), "701838704095920198", "Family");
        $embed->add_field(array("name" => "Field 1", "value" => "Field 1 Value"), array("name" => "Field 2", "value" => "Field 2 Value"));
        $embed->send_embed();

        /* Embed End */

        /* Bulk Delete Start */
        $ids = "";
        // Count Messages
        foreach (json_decode($this->channel->getMessages($channel)) as $key => $item) {
            if($key == 99){
                return;
            }
            count(json_decode($this->channel->getMessages($channel))) -1 == $key?
                $ids .= "\"$item->id\"" : $ids.= "\"$item->id\",";
        }
        // Delete Messages
        $this->channel->deleteBulkMessage("[{$ids}]", $channel);


        parent::run();

    }
}

class EventListener extends \Ourted\Model\EventListener\EventListener
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

    # Message
    public function onMessageCreate($json, $bot)
    {

    }

    # Bot
    public function onReady($json, $bot)
    {

    }


}


new Ourted();