<?php

use GuzzleHttp\Client;

class Bot extends DB
{
    private PDO $pdo;
    public $http;

    const string TOKEN = "7346592725:AAGeHRRLzone7-nWCVZR5tpZMZlOvt5WCrY";
    const string REQUIEST_API = "https://api.telegram.org/bot" . self::TOKEN . "/";
    public function __construct()
    {
        $this->pdo = DB::connect();
        $this->http = new Client(['base_uri' => self::REQUIEST_API]);
    }
    public function sendMessage(int $chatId, string $text, $reply_markup = null)
    {
        $params = [
            'chat_id' => $chatId,
            'text' => $text
        ];
        $reply_markup ? $params['reply_markup'] = json_encode($reply_markup) : null;
        $this->http->post('sendMessage', [
            'form_params' => $params
        ]);

    }
    public function startBot(int $chatId)
    {
        $user = new User();
        $user->saveUser($chatId);
        $this->sendMessage($chatId,"Welcome");
    }

    public function addHandler(int $chatId)
    {
        $user = new User();
        $user->setStatus($chatId, 'add');
        $this->sendMessage($chatId,"Pleace enter your task");
    }

    public function handlerSaveTodo(int $chatId, string $text)
    {
        $user = new User();
        $user = $user->getUserInfo($chatId);

        $todo = new Todo();
        $todo->saveTodo($text, $user->id);

        $this->sendMessage($chatId,"Task saved");
    }

    public function prepareButtons($todos, $additional_button=[])
    {
        $i = 0;
        $keyboard = [];
        foreach ($todos as $todo) {
            $i++;
            $keyboard[] = ['text' => $i, 'callback_data' => $todo['id']];
        }
        $additional_button ? $keyboard[] = $additional_button : null;
        $reply_markup = [
            'inline_keyboard' => array_chunk($keyboard, 2)
        ];
        return $reply_markup;
    }

    public function prepareText($todos):string
    {
        $i = 0;
        $text = "";
        foreach ($todos as $todo) {
            $i++;
            $text .= $i . ") " . ($todo['status'] ? '✅' : '❎') . $todo['title'] . "\n";
        }
        return $text;
    }
    public function getAllTodos(int $chatId)
    {
        $user = new User();
        $user = $user->getUserInfo($chatId);

        $todo = new Todo();
        $todos = $todo->getAllTodosByUser($user->id);
        $reply_markup = $this->prepareButtons($todos, ['text'=>'🗑Delete', 'callback_data'=>'delete']);
        $text = "Your todos: \n" . $this->prepareText($todos);
        $this->sendMessage($chatId,$text, $reply_markup);
    }

    // Calkback query

    public function toggle(int $chatId, int $todoId)
    {

        $todo = new Todo();
        $todo->toggle($todoId);

        $this->getAllTodos($chatId);
    }

    public function chuosetTodo(int $chatId)
    {
        $user = new User();
        $user->setStatus($chatId, 'delete');
        $user = new User();
        $user = $user->getUserInfo($chatId);

        $todo = new Todo();
        $todos = $todo->getAllTodosByUser($user->id);
        $reply_markup = $this->prepareButtons($todos);
        $text = "Chuose your todo: \n" . $this->prepareText($todos);
        $this->sendMessage($chatId,$text, $reply_markup);
    }

    public function deletedHandler(int $chatId, int $todoId)
    {
        $user = new User();
        $user = $user->getUserInfo($chatId);
        $todo = new Todo();
        $todo->deleteTodo($todoId);
        $this->getAllTodos($chatId);
    }
}