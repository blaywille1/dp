<?php

interface ServiceVisitor
{
    public function SendMsg(SendMessage $s);
    function PushMsg(PushMessage $p);
}

class AliYun implements ServiceVisitor
{
    public function SendMsg(SendMessage $s)
    {
        echo 'Отправить SMS из облака Alibaba
！', PHP_EOL;
    }
    public function PushMsg(PushMessage $p)
    {
        echo 'Информация о push-уведомлениях об Alibaba Cloud
！', PHP_EOL;
    }
}

class JiGuang implements ServiceVisitor
{
    public function SendMsg(SendMessage $s)
    {
        echo 'Аврора отправляет смс
！', PHP_EOL;
    }
    public function PushMsg(PushMessage $p)
    {
        echo 'Аврора Push SMS
！', PHP_EOL;
    }
}

interface Message
{
    public function Msg(ServiceVisitor $v);
}

class PushMessage implements Message
{
    public function Msg(ServiceVisitor $v)
    {
        echo 'Начать запуск скрипта：';
        $v->PushMsg($this);
    }
}

class SendMessage implements Message
{
    public function Msg(ServiceVisitor $v)
    {
        echo 'Запуск SMS-скрипта：';
        $v->SendMsg($this);
    }
}

class ObjectStructure
{
    private $elements = [];

    public function Attach(Message $element)
    {
        $this->elements[] = $element;
    }

    public function Detach(Message $element)
    {
        $position = 0;
        foreach ($this->elements as $e) {
            if ($e == $element) {
                unset($this->elements[$position]);
                break;
            }
            $position++;
        }
    }

    public function Accept(ServiceVisitor $visitor)
    {
        foreach ($this->elements as $e) {
            $e->Msg($visitor);
        }
    }

}

$o = new ObjectStructure();
$o->Attach(new PushMessage());
$o->Attach(new SendMessage());

$v1 = new AliYun();
$v2 = new JiGuang();

$o->Accept($v1);
$o->Accept($v2);
