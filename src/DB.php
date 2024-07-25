<?php

declare(strict_types=1);

class DB
{
    public function __construct()
    {
        $this->pdo = new PDO(
            "mysql:host=localhost;dbname=todo_list",
            'abdurashid',
            'Abdu_1504',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    public static function connect(): PDO
    {
        $pdo = new PDO(
            "mysql:host=localhost;dbname=todo_list",
            'abdurashid',
            'Abdu_1504',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
        return $pdo;
    }
}