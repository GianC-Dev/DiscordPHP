<?php

namespace Ourted\Model\Message;

use Ourted\Utils\Functions;

class Embed extends Functions
{


    protected $bot;
    protected $token;
    private $embed = [];
    private $fields = [];
    private $fields_arr = [];


    /**
     *
     *
     * @param $title
     * @param $bot
     * @param $channel_id
     * @param string $description
     */
    public function __construct($title, $bot, $channel_id, $description = "")
    {
        parent::__construct($bot->getBot());
        $this->embed['title'] = $title;
        $this->embed['description'] = $description;
        $this->embed['channel_id'] = $channel_id;
        $this->bot = $bot->getBot();
        $this->token = $bot->getToken();
    }

    /**
     * @var array $field Fields In Array
     *
     */

    public function add_field(array ...$field)
    {
        if(isset($field[0][0])){
            $this->fields[] = $field;
        }else{
            $this->fields_arr[] = $field;
        }

    }

    /**
     * Get added fields
     *
     * @return string
     */
    private function get_fields()
    {
        $data = "";
        if (!isset($this->fields[0][0][0])){
            foreach ($this->fields_arr[0] as $key => $item) {
                $toplam_field = count($this->fields_arr);
                $data .= $toplam_field == $key ?
                    // If
                    "{\"name\":\"{$item["name"]}\",\"value\":\"{$item["value"]}\"}" :
                    // If Not
                    "{\"name\":\"{$item["name"]}\",\"value\":\"{$item["value"]}\"},";
            }
        }else {
            foreach ($this->fields[0][0] as $key => $item) {
                $toplam_field = count($this->fields[0][0][0]);
                $data .= $toplam_field - 1 == $key ?
                    // If
                    "{\"name\":\"{$item["name"]}\",\"value\":\"{$item["value"]}\"}" :
                    // If Not
                    "{\"name\":\"{$item["name"]}\",\"value\":\"{$item["value"]}\"},";
            }
        }
        return $data;
    }

    public
    function send_embed()
    {
        $headers = array();
        $headers[] = 'Authorization: Bot ' . $this->token;
        $headers[] = 'User-Agent: Ourted (http://example.com, v0.1)';

        $headers[] = 'Content-Type: application/json';
        $field = "{
  \"content\": \"\",
  \"tts\": false,
  \"embed\": {
    \"title\": \"{$this->embed['title']}\",
    " . ($this->embed['description'] != "" ?
                "\"description\": \"{$this->embed['description']}\"," : null) .
            "\"type\":\"rich\",
   \"fields\": [" . $this->get_fields() . "]
  }
}";
        parent::init_curl_with_header(
            "channels/{$this->embed['channel_id']}/messages",
            $headers, $field, "POST");
    }

}