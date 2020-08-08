<?php

namespace Ourted\Utils;

use Ourted\Bot;

class API{

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
    public function init_curl_with_header($url, $field, $request = "POST")
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://discord.com/api/v6/" . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $field);
        $headers = array();
        $headers[] = 'Retry-After: 500';
        $headers[] = 'X-RateLimit-Limit: 10';
        $headers[] = 'X-RateLimit-Remaining: 0';
        $headers[] = 'X-RateLimit-Reset: 147017';
        $headers[] = 'X-RateLimit-Reset-After: 5';
        $headers[] = 'X-RateLimit-Bucket: abcd1234';
        $headers[] = 'Authorization: Bot ' . $this->token;
        $headers[] = 'User-Agent: Ourted (http://example.com, v0.1)';
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        return curl_exec($ch);
    }

    /**
     * Init Curl With Header
     *
     * @var array $headers CURLOPT_HTTPHEADER
     * @var string $field CURLOPT_POST
     * @var string|null $tur CURLOPT_CUSTOMREQUEST
     * @var string $url CURLOPT_URL
     */
    public function init_curl_with_header_print_r($url, $headers, $tur = "GET")
    {
        $ch = curl_init();

        $headers[] = 'Retry-After: 500';
        $headers[] = 'X-RateLimit-Limit: 10';
        $headers[] = 'X-RateLimit-Remaining: 0';
        $headers[] = 'X-RateLimit-Reset: 147017';
        $headers[] = 'X-RateLimit-Reset-After: 5';
        $headers[] = 'X-RateLimit-Bucket: abcd1234';
        curl_setopt($ch, CURLOPT_URL, "https://discord.com/api/v6/" . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $tur);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        print_r(curl_exec($ch));
    }
}