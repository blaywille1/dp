<?php

class Product
{
    private $parts = [];

    public function Add(string $part): void
    {
        $this->parts[] = $part;
    }

    public function Show(): void
    {
        echo PHP_EOL.'Создание продукта
 ----', PHP_EOL;
        foreach ($this->parts as $part) {
            echo $part, PHP_EOL;
        }
    }
}

// Категория продукта, вы можете думать о ней как о доме, который
// мы хотим построить. В настоящее время в доме нет содержимого,
// и нам нужно внести в него свой вклад.

interface Builder
{
    public function BuildPartA(): void;

    public function BuildPartB(): void;

    public function GetResult(): Product;
}

class ConcreteBuilder1 implements Builder
{
    private $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function BuildPartA(): void
    {
        $this->product->Add('Часть А
');
    }

    public function BuildPartB(): void
    {
        $this->product->Add('Часть B');
    }

    public function GetResult(): Product
    {
        return $this->product;
    }
}

class ConcreteBuilder2 implements Builder
{
    private $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function BuildPartA(): void
    {
        $this->product->Add('Часть X
');
    }

    public function BuildPartB(): void
    {
        $this->product->Add('Вечеринка');
    }

    public function GetResult(): Product
    {
        return $this->product;
    }
}

// Строительная абстракция и ее реализация. Разные разработчики всегда
// выбирают разные фирменные материалы.У нас есть два разных разработчика,
// но их цель одна и та же, оба - построить дом (продукт).

class Director
{
    public function Construct(Builder $builder)
    {
        $builder->BuildPartA();
        // $builder->BuildPartB();
    }
}

/*
Конструктор, используемый для вызова строителя на производство.

 Правильно, это наша команда инженеров. Он выбирает материалы и строит.

Одна и та же команда инженеров может выполнять разные заказы, но все,
 что они строят, - это дома. Просто материалы и внешний вид у этого дома
разные, а мастерство в целом осталось прежним.

*/
$director = new Director();
$b1 = new ConcreteBuilder1();
$b2 = new ConcreteBuilder2();

$director->Construct($b1);
$p1 = $b1->getResult();
$p1->Show();

$director->Construct($b2);
$p2 = $b2->getResult();
$p2->Show();
