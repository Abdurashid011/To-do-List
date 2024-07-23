<?php

declare(strict_types=1);

use GuzzleHttp\Client;

require 'vendor/autoload.php';
require 'src/User.php';

$user = new User();

$token = "7346592725:AAGeHRRLzone7-nWCVZR5tpZMZlOvt5WCrY";
$tgApi = "https://api.telegram.org/bot$token/";

$client = new Client(['base_uri' => $tgApi]);

$update = json_decode(file_get_contents('php://input'));


$user = new User();

$path = parse_url($_SERVER['REQUEST_URI'])['path'];

if (isset($update->update_id)) {
    require 'bot.php';
} else {
    switch($path) {
        case '/add':
            $user->saveAdd($update->text);
            break;
        case '/getAll':
            print_r($user->SendAllUsers());
            break;
        case '/delete':
            $user->saveDelete(($update->text)-1);
            break;
        case '/check':
            $user->saveCheck(($update->text)-1);
            break;
        case '/uncheck':
            $user->saveUncheck(($update->text)-1);
            break;
        default:
            echo "Not found";
            break;
    }
}


if (isset($update->message)) {
    $message = $update->message->text;
    $chat_id = $update->message->chat->id;
    $text = $update->message->text;

    if ($text === '/start') {
        $client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => 'welcome'
            ]
        ]);
        return;
    }

    if ($text === '/add') {
        $user->addTask('add');
        $client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => 'Enter the task'
            ]
        ]);
        return;
    }

    if ($text === '/check') {
        $user->checkTask('check');
        $client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => 'Enter the number check'
            ]
        ]);
        return;
    }

    if ($text === '/uncheck') {
        $user->uncheckTask('uncheck');
        $client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => 'Enter the number uncheck'
            ]
        ]);
        return;
    }

    if ($text === '/get') {
        $tasks = $user->SendAllUsers();
        $responseText = '';
        $count = 1;

        foreach ($tasks as $task) {
            if ($task['completed'] == 1) {
                $responseText .= $count . ': <del>' . $task['title'] . '</del>' . "\n";
            } else {
                $responseText .= $count . ': ' . $task['title'] . "\n";
            }
            $count++;
        }

        $client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => $responseText,
                'parse_mode' => 'HTML'
            ]
        ]);
        return;

    }

    if ($text === '/delete') {
        $user->writeDelete('delete');
        $client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => 'Enter the number delete'
            ]
        ]);
        return;
    }
}

if ($text) {
    $add = $user->getAdd();
    if ($add[0]['add'] == 'add') {
        $user->saveAdd($text);
        $user->deleteAdd();
        $client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => 'Task added successfully'
            ]
        ]);
        return;
    }

    $check = $user->getCheck();
    if ($check[0]['check'] == 'check') {
        $user->saveCheck((int)$text);
        $user->deleteCheck();
        $client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => 'Task checked successfully'
            ]
        ]);
        return;
    }

    $uncheck = $user->getUncheck();
    if ($uncheck[0]['uncheck'] == 'uncheck') {
        $user->saveUncheck((int)$text);
        $user->deleteUncheck();
        $client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => 'Task Unchecked successfully'
            ]
        ]);
        return;
    }

    $delete = $user->getDelete();
    if ($delete[0]['delete'] == 'delete') {
        $user->saveDelete((int)$text - 1);
        $user->dropDelete();
        $client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => 'Task deleted successfully'
            ]
        ]);
        return;
    }
}