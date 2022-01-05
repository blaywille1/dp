<?php

class Message
{
    public function send()
    {
        echo "Отправить SMS из облака Alibaba！".PHP_EOL;
    }

    public function push()
    {
        echo "Alibaba Cloud отправляет push！".PHP_EOL;
    }
}

class JiguangSDKAdapter extends Message
{
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function send()
    {
        $this->message->send_out_msg();
    }

    public function push()
    {
        $this->message->push_msg();
    }
}

class JiguangMessage
{
    public function send_out_msg()
    {
        echo "Аврора отправляет смс！".PHP_EOL;
    }

    public function push_msg()
    {
        echo "Аврора отправить толчок！".PHP_EOL;
    }
}

class BaiduYunSDKAdapter extends Message
{
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function send()
    {
        $this->message->transmission_msg();
    }

    public function push()
    {
        $this->message->transmission_push();
    }
}

class BaiduYunMessage
{
    public function transmission_msg()
    {
        echo "Отправить SMS из Baidu Cloud！".PHP_EOL;
    }

    public function transmission_push()
    {
        echo "Облако Baidu push push！".PHP_EOL;
    }
}

$jiguangMessage = new JiguangMessage();
$baiduYunMessage = new BaiduYunMessage();
$message = new Message();

// Исходная старая система отправляет текстовые сообщения,
// используя Alibaba Cloud
$message->send();
$message->push();


// Используйте Аврору для отправки некоторых модулей
$jgAdatper = new JiguangSDKAdapter($jiguangMessage);
$jgAdatper->send();
$jgAdatper->push();

// Используйте Baidu Cloud для отправки некоторых модулей
$bdAatper = new BaiduYunSDKAdapter($baiduYunMessage);
$bdAatper->send();
$bdAatper->push();
