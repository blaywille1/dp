<?php

interface MsgIterator
{
    public function First();

    public function Next();

    public function IsDone();

    public function CurrentItem();
}

// Прямой итератор
class MsgIteratorAsc implements MsgIterator
{
    private $list;
    private $index;

    public function __construct($list)
    {
        $this->list = $list;
        $this->index = 0;
    }

    public function First()
    {
        $this->index = 0;
    }

    public function Next()
    {
        $this->index++;
    }

    public function IsDone()
    {
        return $this->index >= count($this->list);
    }

    public function CurrentItem()
    {
        return $this->list[$this->index];
    }
}

// Обратный итератор
class MsgIteratorDesc implements MsgIterator
{
    private $list;
    private $index;

    public function __construct($list)
    {
        // Обратный массив
        $this->list = array_reverse($list);
        $this->index = 0;
    }

    public function First()
    {
        $this->index = 0;
    }

    public function Next()
    {
        $this->index++;
    }

    public function IsDone()
    {
        return $this->index >= count($this->list);
    }

    public function CurrentItem()
    {
        return $this->list[$this->index];
    }
}

interface Message
{
    public function CreateIterator($list);
}

class MessageAsc implements Message
{
    public function CreateIterator($list)
    {
        return new MsgIteratorAsc($list);
    }
}

class MessageDesc implements Message
{
    public function CreateIterator($list)
    {
        return new MsgIteratorDesc($list);
    }
}

// Список номеров для отправки SMS
$mobileList = [
    '13111111111',
    '13111111112',
    '13111111113',
    '13111111114',
    '13111111115',
    '13111111116',
    '13111111117',
    '13111111118',
];

// Серверный скрипт или используйте swoole для отправки половины прямого направления
$serverA = new MessageAsc();
$iteratorA = $serverA->CreateIterator($mobileList);

while ( ! $iteratorA->IsDone()) {
    echo $iteratorA->CurrentItem(), PHP_EOL;
    $iteratorA->Next();
}

// Серверный скрипт B или используйте swoole для синхронной отправки половины обратного сообщения
$serverB = new MessageDesc();
$iteratorB = $serverB->CreateIterator($mobileList);

while ( ! $iteratorB->IsDone()) {
    echo $iteratorB->CurrentItem(), PHP_EOL;
    $iteratorB->Next();
}
