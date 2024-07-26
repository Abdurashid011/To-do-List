<?php
require 'src/DB.php';
require 'src/Todo.php';

$pdo = DB::connect();
$todo = new Todo($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $todo->saveTodo($_POST['title']);
                break;
            case 'toggle':
                $todo->toggle((int)$_POST['id']);
                break;
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $todo->deleteTodo((int)$_GET['id']);
}

header('Content-Type: application/json, UTF-8');
header('Location: index.php');
exit;