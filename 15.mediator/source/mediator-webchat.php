<?php

abstract class Mediator
{
    abstract public function Send($message, $user);
}

class ChatMediator extends Mediator
{
    public $users = [];

    public function Attach($user)
    {
        if ( ! in_array($user, $this->users)) {
            $this->users[] = $user;
        }
    }

    public function Detach($user)
    {
        $position = 0;
        foreach ($this->users as $u) {
            if ($u == $user) {
                unset($this->users[$position]);
            }
            $position++;
        }
    }

    public function Send($message, $user)
    {
        foreach ($this->users as $u) {
            if ($u == $user) {
                continue;
            }
            $u->Notify($message);
        }
    }
}

abstract class User
{
    public $mediator;
    public $name;

    public function __construct($mediator, $name)
    {
        $this->mediator = $mediator;
        $this->name = $name;
    }
}

class ChatUser extends User
{
    public function Send($message)
    {
        $this->mediator->Send($message.'('.$this->name.'Отправить)', $this);
    }

    public function Notify($message)
    {
        echo $this->name.'Получил новости：'.$message, PHP_EOL;
    }
}

$m = new ChatMediator();

$u1 = new ChatUser($m, 'Пользователь 1
');
$u2 = new ChatUser($m, 'Пользователь 2
');
$u3 = new ChatUser($m, 'Пользователь 3
');

$m->Attach($u1);
$m->Attach($u3);
$m->Attach($u2);

$u1->Send('Hello, всем привет
！'); // Пользователь 2 и пользователь 3 получают сообщение


$u2->Send('Привет！'); // Пользователь 1, пользователь 3 получают сообщение


$m->Detach($u2); // Пользователь 2 выходит из чата


$u3->Send('欢迎欢迎！'); // Пользователь 1 получает сообщение

