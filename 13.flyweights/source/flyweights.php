<?php

interface Flyweight
{
    public function operation($extrinsicState): void;
}

class ConcreteFlyweight implements Flyweight
{
    private $intrinsicState = 101;

    function operation($extrinsicState): void
    {
        echo 'Общий объект-легковес
'.($extrinsicState + $this->intrinsicState).PHP_EOL;
    }
}

class UnsharedConcreteFlyweight implements Flyweight
{
    private $allState = 1000;

    public function operation($extrinsicState): void
    {
        echo 'Необщий легковесный объект：'.($extrinsicState + $this->allState)
            .PHP_EOL;
    }
}

// Определите общий интерфейс и его реализацию.Обратите внимание,
// что существует две реализации: ConcreteFlyweigh разделяет состояние,
// а UnsharedConcreteFlyweight не разделяет или его состояние
// не требует совместного использования.

class FlyweightFactory
{
    private $flyweights = [];

    public function getFlyweight($key): Flyweight
    {
        if ( ! array_key_exists($key, $this->flyweights)) {
            echo "create", PHP_EOL;
            $this->flyweights[$key] = new ConcreteFlyweight();
        }
        var_dump($this->flyweights);

        return $this->flyweights[$key];
    }
}

// Сохраните те объекты, которые должны быть общими, как фабрику
// для создания требуемых общих объектов, чтобы гарантировать,
// что будут только уникальные объекты с одним и тем же значением ключа,
// сэкономив накладные расходы на создание одного и того же объекта.

$factory = new FlyweightFactory();

$extrinsicState = 100;
$flA = $factory->getFlyweight('a');
$flA->operation(--$extrinsicState);

$flB = $factory->getFlyweight('b');
$flB->operation(--$extrinsicState);

$flC = $factory->getFlyweight('c');
$flC->operation(--$extrinsicState);

$flD = new UnsharedConcreteFlyweight();
$flD->operation(--$extrinsicState);

$c = $factory->getFlyweight('c');

