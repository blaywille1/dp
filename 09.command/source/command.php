<?php

/*
Прежде всего, мы определяем получателя команды или, что более уместно,
 инициатора команды.
Английское определение слова на диаграмме классов - «invoker».
То есть он инициирует и управляет командами.
*/

class Invoker
{
    public $command;

    public function __construct($command)
    {
        $this->command = $command;
    }

    public function exec()
    {
        $this->command->execute();
    }
}

/*
Далее идет команда, которая является нашим «меню».
Цель этой команды - определить, кто настоящий исполнитель.
*/

abstract class Command
{
    protected $receiver;

    public function __construct(Receiver $receiver)
    {
        $this->receiver = $receiver;
    }

    abstract public function execute();
}

class ConcreteCommand extends Command
{
    public function execute()
    {
        $this->receiver->action();
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
}

// Готов к выступлению
$receiverA = new Receiver('A');

// Подготовить заказ
$command = new ConcreteCommand($receiverA);

// Запрашивающий
$invoker = new Invoker($command);
$invoker->exec();

/*
Для звонка клиента мы должны связаться с исполнителем,
то есть выбрать ресторан с хорошими поварами (Receiver),
затем подготовить команду, которая является меню (Command), и, наконец,
передать ее официанту (Invoker).

Фактически, пример этого ресторана очень нагляден,
и это прекрасный анализ командного режима.
Как насчет того, чтобы сделать несколько заказов или дать несколько поваров?
 Не волнуйтесь, следующий код поможет нам решить эту проблему.
*/
