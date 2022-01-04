<?php

//Сначала сделаем получателя, содержащего реализации
// каждого действия, которое может быть выполнено.


// Receiver
interface Command
{
    public function execute();

    public function undo();

    public function redo();
}

//Теперь сделаем интерфейс, который будет реализовывать каждая команда.
// Также сделаем набор команд.

class Bulb
{
    public function turnOn()
    {
        echo "Bulb has been lit";
    }

    public function turnOff()
    {
        echo "Darkness!";
    }
}

// Command

class TurnOn implements Command
{
    protected $bulb;

    public function __construct(Bulb $bulb)
    {
        $this->bulb = $bulb;
    }

    public function undo()
    {
        $this->bulb->turnOff();
    }

    public function redo()
    {
        $this->execute();
    }

    public function execute()
    {
        $this->bulb->turnOn();
    }
}

class TurnOff implements Command
{
    protected $bulb;

    public function __construct(Bulb $bulb)
    {
        $this->bulb = $bulb;
    }

    public function undo()
    {
        $this->bulb->turnOn();
    }

    public function redo()
    {
        $this->execute();
    }

    public function execute()
    {
        $this->bulb->turnOff();
    }
}

//Теперь сделаем вызывающего Invoker, с которым будет взаимодействовать
// клиент для обработки команд.


// Invoker
class RemoteControl
{
    public function submit(Command $command)
    {
        $command->execute();
    }
}

//Посмотрим, как всё это может использовать клиент:


$bulb = new Bulb();

$turnOn = new TurnOn($bulb);
$turnOff = new TurnOff($bulb);

$remote = new RemoteControl();
$remote->submit($turnOn); // Лампочка зажглась!
$remote->submit($turnOff); // Темнота!

//Шаблон «Команда» можно использовать и для реализации системы на основе
// транзакций. То есть системы, в которой вы сохраняете историю команд
// по мере их выполнения. Если последняя команда выполнена успешно,
// то всё хорошо. В противном случае система итерирует по истории
// и делает undo для всех выполненных команд.
