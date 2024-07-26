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
            $save_user->bindParam(':chat_id', $chatId,PDO::PARAM_INT);
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

    public function getStatus(int $chatId){
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
}