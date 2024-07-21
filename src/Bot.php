<?php

declare(strict_types=1);

use GuzzleHttp\Client;

class Bot
{
    const TOKEN = "7346592725:AAGeHRRLzone7-nWCVZR5tpZMZlOvt5WCrY";
    const API = "https://api.telegram.org/bot" . self::TOKEN . "/";

    public Client $http;

    public function __construct()
    {
        $this->http = new Client(['base_uri' => self::API]);
    }

    public function handleStartCommand($chatId)
    {
        $this->http->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => "Welcome"
            ]
        ]);
    }

    public function addHandlerCommand($chatId)
    {
        $this->http->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => "Enter task"
            ]
        ]);
    }

}
