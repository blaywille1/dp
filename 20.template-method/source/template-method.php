<?php

abstract class AbstractClass
{
    public function TemplateMethod()
    {
        $this->PrimitiveOperation1();
        $this->PrimitiveOperation2();
    }

    abstract public function PrimitiveOperation1();

    abstract public function PrimitiveOperation2();
}

// Определяем абстрактный класс с шаблонным методом TemplateMethod(),
// в котором мы вызываем метод работы алгоритма. И эти абстрактные
// методы алгоритма реализованы в подклассах.
class ConcreteClassA extends AbstractClass
{
    public function PrimitiveOperation1()
    {
        echo 'Конкретный метод реализации класса A 1
', PHP_EOL;
    }

    public function PrimitiveOperation2()
    {
        echo 'Конкретный метод реализации класса А 2
', PHP_EOL;
    }
}

class ConcreteClassB extends AbstractClass
{
    public function PrimitiveOperation1()
    {
        echo 'Конкретный способ реализации класса B 1
', PHP_EOL;
    }

    public function PrimitiveOperation2()
    {
        echo 'Конкретный метод реализации класса B 2
', PHP_EOL;
    }
}

// Для определенных классов реализации им нужно только реализовать алгоритм,
// определенный родительским классом.
$c = new ConcreteClassA();
$c->TemplateMethod();

$c = new ConcreteClassB();
$c->TemplateMethod();
