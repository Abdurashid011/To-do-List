<?php
require 'DB.php';
require 'Todo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdo = DB::connect();
    $todo = new Todo($pdo);

    $todo->addTodo($_POST['title']);

    header('Location: index.php');
    exit;
}
