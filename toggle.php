<?php
require 'Database.php';
require 'Todo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $todo = new Todo($database->pdo);
    $todo->toggleTodoStatus($_POST['id']);
    header('Location: index.php');
    exit;
}

