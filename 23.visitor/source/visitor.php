<?php

interface Visitor
{
    function VisitConcreteElementA(ConcreteElementA $a);

    function VisitConcreteElementB(ConcreteElementB $b);
}

class ConcreteVisitor1 implements Visitor
{
    public function VisitConcreteElementA(ConcreteElementA $a)
    {
        echo get_class($a)."лоскутное одеяло
".get_class($this)."доступ", PHP_EOL;
    }

    public function VisitConcreteElementB(ConcreteElementB $b)
    {
        echo get_class($b)."лоскутное одеяло
".get_class($this)."доступ", PHP_EOL;
    }
}

class ConcreteVisitor2 implements Visitor
{
    public function VisitConcreteElementA(ConcreteElementA $a)
    {
        echo get_class($a)."лоскутное одеяло
".get_class($this)."доступ", PHP_EOL;
    }

    public function VisitConcreteElementB(ConcreteElementB $b)
    {
        echo get_class($b)."лоскутное одеяло
".get_class($this)."доступ", PHP_EOL;
    }
}

// Абстрактный интерфейс посетителя и две конкретные реализации.
// Это можно расценивать как молодую пару, пришедшую к нам в гости!
interface Element
{
    public function Accept(Visitor $v);
}

class ConcreteElementA implements Element
{
    public function Accept(Visitor $v)
    {
        $v->VisitConcreteElementA($this);
    }

    public function OperationA()
    {

    }
}

class ConcreteElementB implements Element
{
    public function Accept(Visitor $v)
    {
        $v->VisitConcreteElementB($this);
    }

    public function OperationB()
    {

    }
}

// Абстракция и реализация элементов также могут рассматриваться
// как сущности, к которым нужно получить доступ.
// Конечно, это я и моя жена.
class ObjectStructure
{
    private $elements = [];

    public function Attach(Element $element)
    {
        $this->elements[] = $element;
    }

    public function Detach(Element $element)
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

    public function Accept(Visitor $visitor)
    {
        foreach ($this->elements as $e) {
            $e->Accept($visitor);
        }
    }

}

// Это объектная структура, которая содержит сущности элементов
// и выполняет вызовы доступа. Давайте встретимся в гостиной
// и поприветствуем друг друга, это гостиная
$o = new ObjectStructure();
$o->Attach(new ConcreteElementA());
$o->Attach(new ConcreteElementB());

$v1 = new ConcreteVisitor1();
$v2 = new ConcreteVisitor2();

$o->Accept($v1);
$o->Accept($v2);
