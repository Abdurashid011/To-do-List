<?php
require 'vendor/autoload.php';
require 'src/DB.php';
require 'src/Todo.php';

date_default_timezone_set("Asia/Tashkent");

$database = DB::connect();
$todo = new Todo($database);
$todos = $todo->getTodos();

$update = json_decode(file_get_contents('php://input'));

if (isset($update)) {
    require 'bot/bot.php';
    return;
}

require 'view.php';
