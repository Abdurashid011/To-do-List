<?php

class User extends DB
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    public function saveUser(int $chatId)
    {
        $check_user = $this->pdo->prepare("SELECT * FROM `users` WHERE `chat_id` = :chat_id");
        $check_user->bindParam(':chat_id', $chatId);
        $check_user->execute();
        if (!$check_user->fetch()) {
            $save_user = $this->pdo->prepare("INSERT INTO users (chat_id) VALUES (:chat_id)");
            $save_user->bindParam(':chat_id', $chatId, PDO::PARAM_INT);
            $save_user->execute();
        }
    }

    public function setStatus(int $chatId, string $status)
    {
        $update = $this->pdo->prepare("UPDATE `users` SET `status` = :status WHERE `chat_id` = :chat_id");
        $update->bindParam(':status', $status);
        $update->bindParam(':chat_id', $chatId);
        $update->execute();
    }

    public function getStatus(int $chatId)
    {
        $status = $this->pdo->prepare("SELECT * FROM `users` WHERE `chat_id` = :chat_id");
        $status->bindParam(':chat_id', $chatId);
        $status->execute();
        return $status->fetch(PDO::FETCH_OBJ);
    }

    public function getUserInfo(int $chatId)
    {
        $user = $this->pdo->prepare("SELECT * FROM `users` WHERE `chat_id` = :chat_id");
        $user->bindParam(':chat_id', $chatId);
        $user->execute();
        return $user->fetch(PDO::FETCH_OBJ);
    }

    // **************** Bu yerda registratsiya uchun kodlar yozilgan ****************
    public function create(string $email, string $password): string
    {
        $user = $this->pdo->prepare("SELECT * FROM `users` WHERE `email` = :email");
        $user->bindParam(':email', $email);
        $user->bindParam(':password', $password);
        $user->execute();
        if (count($user->fetchAll()) > 0) {
            return 'Email alredy exists';
        }
        $stmt = $this->pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $result = $stmt->execute();

        return $result ? "New record created successfully" : "Something went wrong";
    }

    public function login(string $email, string $password): string
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `email` = :email");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? 'Logged in successfully' : 'Something went wrong';
    }
}
