<?php
require 'Database.php';
require 'Todo.php';

$database = new Database();
$todo = new Todo($database->pdo);
$todo->deleteTodo($_GET['id']);
header('Location: index.php');
exit;

