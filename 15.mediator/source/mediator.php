<?php

abstract class Mediator
{
    abstract public function Send(string $message, Colleague $colleague);
}

class ConcreteMediator extends Mediator
{
    public $colleague1;
    public $colleague2;

    public function Send(string $message, Colleague $colleague)
    {
        if ($colleague == $this->colleague1) {
            $this->colleague2->Notify($message);
        } else {
            $this->colleague1->Notify($message);
        }
    }
}

// Абстрагированный посредник и конкретная реализация.Здесь мы предполагаем,
// что есть два фиксированных класса коллег, чтобы они могли общаться
// друг с другом, поэтому, когда входящий коллега равен 1,
// вызывается метод Notify 2, что эквивалентно разрешению 2 получать
// Сообщение от 1

abstract class Colleague
{
    protected $mediator;

    public function __construct(Mediator $mediator)
    {
        $this->mediator = $mediator;
    }

}

class ConcreteColleague1 extends Colleague
{
    public function Send(string $message)
    {
        $this->mediator->Send($message, $this);
    }

    public function Notify(string $message)
    {
        echo "Коллега 1 получает информацию
：".$message, PHP_EOL;
    }
}

class ConcreteColleague2 extends Colleague
{
    public function Send(string $message)
    {
        $this->mediator->Send($message, $this);
    }

    public function Notify(string $message)
    {
        echo "Коллега 2 получает информацию
：".$message;
    }
}

// Класс коллег и конкретная реализация, мы хотим здесь подтвердить,
// что каждый класс коллег знает только посредника и не знает другого
// класса коллег. Это характеристика посредника, и обеим сторонам
// не нужно знать каждый разное.

$m = new ConcreteMediator();

$c1 = new ConcreteColleague1($m);
$c2 = new ConcreteColleague2($m);

$m->colleague1 = $c1;
$m->colleague2 = $c2;

$c1->Send("吃过饭了吗？");
$c2->Send("Нет, вы планируете лечить?
");
