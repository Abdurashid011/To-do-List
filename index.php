<?php

declare(strict_types=1);

require 'vendor/autoload.php';

date_default_timezone_set("Asia/Tashkent");

$todo = new Todo();
$todos = $todo->getTodos();


$router = new Router();

if ($router->isApiCall()) {
    require "routes/api.php";
    return;
}

if ($router->isTelegramUpdate()) {
    require "routes/telegram.php";
    return;
}

/* ----- Web part ----- */
require 'view/view.php';