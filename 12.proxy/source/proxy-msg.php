<?php

interface SendMessage
{
    public function Send();
}

class RealSendMessage implements SendMessage
{
    public function Send()
    {
        echo 'Отправка SMS ...
', PHP_EOL;
    }
}

class ProxySendMessage implements SendMessage
{
    private $realSendMessage;

    public function __construct($realSendMessage)
    {
        $this->realSendMessage = $realSendMessage;
    }

    public function Send()
    {
        echo 'SMS начать отправку
', PHP_EOL;
        $this->realSendMessage->Send();
        echo 'Окончание отправки СМС
', PHP_EOL;
    }
}

$sendMessage = new ProxySendMessage(new RealSendMessage());
$sendMessage->Send();
