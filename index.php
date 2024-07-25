<?php

declare(strict_types=1);

require 'vendor/autoload.php';

date_default_timezone_set("Asia/Tashkent");

/*
$todo = new Todo();
$todos = $todo->getTodos();

$update = json_decode(file_get_contents('php://input'));

if (isset($update?->update_id)) {
    require 'bot/bot.php';
    return;
}elseif($update){
    require 'API/api.php';
    return;
}

require "view/view.php";
*/

require 'vendor/autoload.php';

$router = new Router();

if ($router->isApiCall()) {
    require "routes/api.php";
    return;
}

if ($router->isTelegramUpdate()) {
    require "routes/telegram.php";
    return;
}

echo 'Web';
