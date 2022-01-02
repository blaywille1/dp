<?php /** @noinspection PhpHierarchyChecksInspection */

interface Message
{
    public function send(string $msg);
}

interface Push
{
    public function send(string $msg);
}

interface MessageFactory
{
    public function createMessage();

    public function createPush();
}

class AliYunMessage implements Message
{
    public function send(string $msg)
    {
        // вызов интерфейса, отправку текстовых сообщений
        // xxxxx
        return 'Обмен сообщениями в облаке Ali (ранее Ali Fish) отправлен успешно!
         Содержание сообщения: '.$msg;
    }
}

class BaiduYunMessage implements Message
{
    public function send(string $msg)
    {
        // вызов интерфейса, отправку текстовых сообщений
        // вызов интерфейса, отправку текстовых сообщений // XXXXX
        return 'Текстовые сообщения Baidu SMS успешно отправлены!
                    Содержание сообщения: '.$msg;
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

class AliYunPush implements Push
{
    public function send(string $msg)
    {
        // call interface, клиент отправляет push // XXXXX
        return 'Али облако Android и iOS push отправлено успешно!
          Отправить содержимое: '.$msg;

    }
}

class BaiduYunPush implements Push
{
    public function send(string $msg)
    {
        // call interface, клиент отправляет push // XXXXX
        return 'Baidu Android & iOS cloud push успешно отправлен! 
         Отправить содержимое: '.$msg;

    }
}

class JiguangPush implements Push
{
    public function send(string $msg)
    {
        // call interface, клиент отправляет push // XXXXX
        return 'Aurora push успешно отправлен! 
         Отправить содержимое: '.$msg;

    }
}

class AliYunFactory implements MessageFactory
{
    public function createMessage()
    {
        return new AliYunMessage();
    }

    public function createPush()
    {
        return new AliYunPush();
    }
}

class BaiduYunFactory implements MessageFactory
{
    public function createMessage()
    {
        return new BaiduYunMessage();
    }

    public function createPush()
    {
        return new BaiduYunPush();
    }
}

class JiguangFactory implements MessageFactory
{
    public function createMessage()
    {
        return new JiguangMessage();
    }

    public function createPush()
    {
        return new JiguangPush();
    }
}


$factory = new AliYunFactory();
// $factory = new BaiduYunFactory();
// $factory = new JiguangFactory();
$message = $factory->createMessage();
$push = $factory->createPush();
echo $message->send('Вы давно не входили в систему, 
                не забудьте вернуться!');
echo $push->send('У вас есть новый прибыл красный конверт,
                проверьте его!');
