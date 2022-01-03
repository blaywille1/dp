<?php

interface Message
{
    public function send(string $msg);
}

class AliYunMessage implements Message
{
    public function send(string $msg)
    {
        // Вызвать интерфейс и отправить СМС
        // ххххх
        return 'Alibaba  Cloud SMS (ранее Ali Big Fish) успешно отправлено!
         Содержание сообщения: '.$msg;

    }
}

class BaiduYunMessage implements Message
{
    public function send(string $msg)
    {
        // Вызвать интерфейс и отправить СМС
        // ххххх
        return 'Baidu  SMS-сообщение успешно отправлено! Содержание сообщения: '
            .$msg;
    }
}

class JiguangMessage implements Message
{
    public function send(string $msg)
    {
        // Вызвать интерфейс и отправить СМС
        // ххххх
        return 'Сообщения Авроры успешно отправлены! Содержание сообщения: '
            .$msg;
    }
}


abstract class MessageFactory
{
    public function getMessage()
    {
        return $this->factoryMethod();
    }

    abstract protected function factoryMethod();
}

class AliYunFactory extends MessageFactory
{
    protected function factoryMethod()
    {
        return new AliYunMessage();
    }
}

class BaiduYunFactory extends MessageFactory
{
    protected function factoryMethod()
    {
        return new BaiduYunMessage();
    }
}

class JiguangFactory extends MessageFactory
{
    protected function factoryMethod()
    {
        return new JiguangMessage();
    }
}

// Текущий бизнес должен использовать Baidu Cloud
$factory = new BaiduYunFactory();
$message = $factory->getMessage();
echo $message->send('У вас новое короткое сообщение, проверьте его');
