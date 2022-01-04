<?php

class Invoker
{
    private $command = [];

    public function setCommand(Command $command)
    {
        $this->command[] = $command;
    }

    public function exec()
    {
        if (count($this->command) > 0) {
            foreach ($this->command as $command) {
                $command->execute();
            }
        }
    }

    public function undo()
    {
        if (count($this->command) > 0) {
            foreach ($this->command as $command) {
                $command->undo();
            }
        }
    }
}

abstract class Command
{
    protected $receiver;
    protected $state;
    protected $name;

    public function __construct(Receiver $receiver, $name)
    {
        $this->receiver = $receiver;
        $this->name = $name;
    }

    abstract public function execute();
}

class ConcreteCommand extends Command
{
    public function execute()
    {
        if ( ! $this->state || $this->state == 2) {
            $this->receiver->action();
            $this->state = 1;
        } else {
            echo $this->name
                .'Команда выполняется и не может быть выполнена снова!', PHP_EOL;
        }

    }

    public function undo()
    {
        if ($this->state == 1) {
            $this->receiver->undo();
            $this->state = 2;
        } else {
            echo $this->name
                .'Команда не была выполнена и не может быть отменена!', PHP_EOL;
        }
    }
}

class Receiver
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function action()
    {
        echo $this->name.'Команда выполнена！', PHP_EOL;
    }

    public function undo()
    {
        echo $this->name.'Заказ отозван！', PHP_EOL;
    }
}

// Готов к выступлению
$receiverA = new Receiver('A');
$receiverB = new Receiver('B');
$receiverC = new Receiver('C');

// Подготовить заказ
$commandOne = new ConcreteCommand($receiverA, 'A');
$commandTwo = new ConcreteCommand($receiverA, 'B');
$commandThree = new ConcreteCommand($receiverA, 'C');

// Запрашивающий
$invoker = new Invoker();
$invoker->setCommand($commandOne);
$invoker->setCommand($commandTwo);
$invoker->setCommand($commandThree);
$invoker->exec();
$invoker->undo();

// Добавляем одного исполнителя, выполняем только одну команду
$invokerA = new Invoker();
$invokerA->setCommand($commandOne);
$invokerA->exec();

// Команда A была выполнена, снова выполняем все исполнители команд, оценка состояния команды A не может вступить в силу
$invoker->exec();


