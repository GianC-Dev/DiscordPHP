<?php



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


        $embed = $this->createEmbed("TITLE", $channel, "DESCIPTION");
        $embed->add_field("Field 1", "Field 1 Value");
        $embed->add_field("Field 2", "Field 2 Value");
        $embed->send_embed();

        /* Embed End */



        /* Bulk Delete Start */

        $ids = "";
        // Count Messages
        foreach ($this->channel->getMessages($channel) as $key => $item) {
            if($key == 99){
                break;
            }
            count(json_decode($this->channel->getMessages($channel))) -1 == $key?
                $ids .= "\"$item->id\"" : $ids.= "\"$item->id\",";
        }
        // Delete Bulk Message
        $this->channel->deleteBulkMessage("[{$ids}]", $channel);

        /* Bulk Delete End */

        // Get Role
        echo $this->guild->getRole($this->guild->getGuild(742361616728719373), 742404691979272203)->name;
        // Result: Test

        // Get Roles
        print_r($this->guild->getRoles($this->guild->getGuild(742361616728719373)));

        // Add Role
        $this->guild->addRole($this->guild->getGuild(742361616728719373), "Test", 80, true, true);

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