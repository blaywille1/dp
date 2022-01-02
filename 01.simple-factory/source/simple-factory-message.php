<?php

interface Message
{
    public function send(string $msg);
}

class AliYunMessage implements Message
{
    public function send(string $msg)
    {
        // вызов интерфейса, отправку текстовых сообщений // XXXXX
        return 'Обмен сообщениями в облаке 
         Ali (ранее Ali Fish) отправлен успешно! 
         Содержание сообщения: '.$msg;

    }
}

class BaiduYunMessage implements Message
{
    public function send(string $msg)
    {
        // вызов интерфейса, отправку текстовых сообщений // XXXXX
        return 'Текстовые сообщения Baidu SMS успешно
          отправлены! Содержание сообщения: '.$msg;

    }
}

class JiguangMessage implements Message
{
    public function send(string $msg)
    {
        // вызов интерфейса, отправку текстовых сообщений // XXXXX
        return 'Aurora SMS успешно отправлено! 
         Содержание сообщения: '.$msg;

    }
}

class MessageFactory
{
    public static function createFactory($type)
    {
        switch ($type) {
            case 'Ali':
                return new AliYunMessage();
            case 'BD':
                return new BaiduYunMessage();
            case 'JG':
                return new JiguangMessage();
            default:
                return null;
        }
    }
}

// Текущие потребности бизнеса использовать Jiguang
$message = MessageFactory::createMessage('Али');
echo $message->send(" У вас есть новое короткое сообщение,
пожалуйста , проверьте его");
