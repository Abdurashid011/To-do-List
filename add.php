<?php
require 'Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $pdo = $database->pdo;

    $stmt = $pdo->prepare('INSERT INTO todos (title) VALUES (?)');
    $stmt->execute([$_POST['title']]);

    header('Location: index.php');
    exit;
}
?>
