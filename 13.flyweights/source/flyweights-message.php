<?php

interface Message
{
    public function send(User $user);
}

class AliYunMessage implements Message
{
    private $template;

    public function __construct($template)
    {
        $this->template = $template;
    }

    public function send(User $user)
    {
        echo 'Используйте Alibaba Cloud SMS, чтобы
'.$user->GetName().'Отправить：';
        echo $this->template->GetTemplate(), PHP_EOL;
    }
}

class JiGuangMessage implements Message
{
    private $template;

    public function __construct($template)
    {
        $this->template = $template;
    }

    public function send(User $user)
    {
        echo 'Используйте SMS Aurora на
'.$user->GetName().'Отправить：';
        echo $this->template->GetTemplate(), PHP_EOL;
    }
}

class MessageFactory
{
    private $messages = [];

    public function GetMessage(Template $template, $type = 'ali')
    {
        $key = md5($template->GetTemplate().$type);
        if ( ! key_exists($key, $this->messages)) {
            if ($type == 'ali') {
                $this->messages[$key] = new AliYunMessage($template);
            } else {
                $this->messages[$key] = new JiGuangMessage($template);
            }
        }

        return $this->messages[$key];
    }

    public function GetMessageCount()
    {
        echo count($this->messages);
    }
}

class User
{
    public $name;

    public function GetName()
    {
        return $this->name;
    }
}

class Template
{
    public $template;

    public function GetTemplate()
    {
        return $this->template;
    }
}

// Внутреннее состояние
$t1 = new Template();
$t1->template = 'Шаблон 1, хорошо
！';

$t2 = new Template();
$t2->template = 'Шаблон 2, хорошо
！';

// Внешнее состояние
$u1 = new User();
$u1->name = 'Чжан Сан
';

$u2 = new User();
$u2->name = 'Ли Си
';

$u3 = new User();
$u3->name = 'Ван Ву
';

$u4 = new User();
$u4->name = 'Чжао Лю
';

$u5 = new User();
$u5->name = 'Тиан Ци
';

// Завод Сянюань
$factory = new MessageFactory();

// Отправка через Alibaba Cloud
$m1 = $factory->GetMessage($t1);
$m1->send($u1);

$m2 = $factory->GetMessage($t1);
$m2->send($u2);

echo $factory->GetMessageCount(), PHP_EOL; // 1

$m3 = $factory->GetMessage($t2);
$m3->send($u2);

$m4 = $factory->GetMessage($t2);
$m4->send($u3);

echo $factory->GetMessageCount(), PHP_EOL; // 2

$m5 = $factory->GetMessage($t1);
$m5->send($u4);

$m6 = $factory->GetMessage($t2);
$m6->send($u5);

echo $factory->GetMessageCount(), PHP_EOL; // 2

// Присоединяйтесь к Авроре
$m1 = $factory->GetMessage($t1, 'jg');
$m1->send($u1);

$m2 = $factory->GetMessage($t1);
$m2->send($u2);

echo $factory->GetMessageCount(), PHP_EOL; // 3

$m3 = $factory->GetMessage($t2);
$m3->send($u2);

$m4 = $factory->GetMessage($t2, 'jg');
$m4->send($u3);

echo $factory->GetMessageCount(), PHP_EOL; // 4

$m5 = $factory->GetMessage($t1, 'jg');
$m5->send($u4);

$m6 = $factory->GetMessage($t2, 'jg');
$m6->send($u5);

echo $factory->GetMessageCount(), PHP_EOL; // 4
