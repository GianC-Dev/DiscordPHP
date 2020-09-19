<?php

namespace Ourted\Utils;

use Ourted\Bot;



class http
{

    /**
     * @var Bot
     */
    public $bot;

    /**
     * @var string
     */
    public $token;

    /**
     * @param Bot
     */
    public function __construct($bot)
    {
        $this->bot = $bot;
        $this->token = $bot->getToken();
    }

    /**
     * Init Curl With Header
     *
     * @return bool|string
     * @var string $url CURLOPT_URL
     * @var string $field CURLOPT_POST
     * @var string|null $tur CURLOPT_CUSTOMREQUEST
     */
    public function send($url, $field, $request = "POST")
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://discord.com/api/v6/" . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $field);
        $headers = array();
        $headers[] = 'Authorization: Bot ' . $this->token;
        $headers[] = 'User-Agent: Ourted (http://example.com, v0.1)';
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (isset(json_decode($result, true)["X-Ratelimit-Remaining"])) {
            $remaining = json_decode($result, true)["X-Ratelimit-Remaining"];
            if ($remaining == 0) {
                $reset = json_decode($result, true)["X-Ratelimit-Reset"] - time();
                echo "We are begin of a rate limit, connect retrying after {$reset} seconds.";
                sleep($reset);
                return $this->send($url, $field, $request);
            }
        }
        return $result;
    }

}