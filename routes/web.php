<?php

$todo = new Todo();
$router = new Router();

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


$router->get('/', fn() => require 'view/pages/home.php');
$router->get('/todos', fn() => require 'view/pages/todos.php');
$router->post('/todos', fn() => 'create todo...');
$router->get('/notes', fn() => require 'view/pages/notes.php');
$router->get('/login', fn() => require 'view/pages/auth/login.php');
$router->post('/login', fn() => (new User())->login($_POST['email'], $_POST['password']));
$router->get('/register', fn() => require 'view/pages/auth/register.php');
$router->post('/register', fn() => (new User())->create($_POST['email'], $_POST['password']));