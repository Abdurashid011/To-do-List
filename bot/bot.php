<?php

declare(strict_types=1);

$bot = new Bot();

if (isset($update->message)) {
    $message = $update->message;
    $chat_id = $message->chat->id;
    $text = $message->text;

    if ($text === '/start') {
        $bot->handleStartCommand($chat_id);
        return;
    }

    if ($text === '/add') {
        $bot->addHandlerCommand($chat_id);
        return;
    }

}


