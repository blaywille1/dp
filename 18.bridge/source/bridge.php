<?php

interface Implementor
{
    public function OperationImp();
}

class ConcreteImplementorA implements Implementor
{
    public function OperationImp()
    {
        echo 'Бетонная реализация A
', PHP_EOL;
    }
}

class ConcreteImplementorB implements Implementor
{
    public function OperationImp()
    {
        echo 'Бетонная реализация B
', PHP_EOL;
    }
}

// Давайте сначала определим интерфейсы реализации и их конкретные
// реализации, то есть функции, которые действительно должны выполняться.
// Это как Adaptee в режиме адаптера.

abstract class Abstraction
{
    protected $imp;

    public function SetImplementor(Implementor $imp)
    {
        $this->imp = $imp;
    }

    abstract public function Operation();
}

class RefinedAbstraction extends Abstraction
{
    public function Operation()
    {
        $this->imp->OperationImp();
    }
}

// Определите интерфейс абстрактного класса и сохраните ссылку на
// реализацию. В методе реализации конкретного абстрактного класса
// мы напрямую вызываем метод реальной операции, реализующий интерфейс.
// Аналогично адаптеру в адаптере.

$impA = new ConcreteImplementorA();
$impB = new ConcreteImplementorB();

$ra = new RefinedAbstraction();

$ra->SetImplementor($impA);
$ra->Operation();

$ra->SetImplementor($impB);
$ra->Operation();
