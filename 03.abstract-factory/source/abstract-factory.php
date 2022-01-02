<?php

//  продукт Абстрактный интерфейс
interface AbstractProductA
{
    public function show(): void;
}

// Товар А1 релизует
class ProductA1 implements AbstractProductA
{
    public function show(): void
    {
        echo 'ProductA1 is Show!'.PHP_EOL;
    }
}

// Реализация товара А2
class ProductA2 implements AbstractProductA
{
    public function show(): void
    {
        echo 'ProductA2 is Show!'.PHP_EOL;
    }
}

// Продукт Б абстрактный интерфейс
interface AbstractProductB
{
    public function show(): void;
}

// Реализация товара Б1
class ProductB1 implements AbstractProductB
{
    public function show(): void
    {
        echo 'ProductB1 is Show!'.PHP_EOL;
    }
}

// Реализация товара Б2
class ProductB2 implements AbstractProductB
{
    public function show(): void
    {
        echo 'ProductB2 is Show!'.PHP_EOL;
    }
}

// абстрактный интерфейс фабрики
interface AbstractFactory
{
    // создание
    public function CreateProductA(): AbstractProductA;

    // создание
    public function CreateProductB(): AbstractProductB;
}

// Фабрика 1, реализует товар A1 и товар B1,
class ConcreteFactory1 implements AbstractFactory
{
    public function CreateProductA(): AbstractProductA
    {
        return new ProductA1();
    }

    public function CreateProductB(): AbstractProductB
    {
        return new ProductB1();
    }
}

// Фабрика 2, реализует товар A2 и товар B2,
class ConcreteFactory2 implements AbstractFactory
{
    public function CreateProductA(): AbstractProductA
    {
        return new ProductA2();
    }

    public function CreateProductB(): AbstractProductB
    {
        return new ProductB2();
    }
}

// 工厂一
$factory1 = new ConcreteFactory1();
$factory1ProductA = $factory1->CreateProductA();
$factory1ProductB = $factory1->CreateProductB();
$factory1ProductA->show();
$factory1ProductB->show();

// 工厂二
$factory2 = new ConcreteFactory2();
$factory2ProductA = $factory2->CreateProductA();
$factory2ProductB = $factory2->CreateProductB();
$factory2ProductA->show();
$factory2ProductB->show();
