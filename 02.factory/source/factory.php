<?php

/*
    Первый - это интерфейсы и классы реализации,
    связанные с товарами, которые похожи на интерфейсы
     простой фабрики:
 * */

// Интерфейс продукта
interface Product
{
    function show(): void;
}

/*
Далее идет класс абстракции и реализации создателя:
*/

// Класс реализации товара А
class ConcreteProductA implements Product
{
    public function show(): void
    {
        echo "I'm A.\n";
    }
}

// Класс реализации товара Б
class ConcreteProductB implements Product
{
    public function show(): void
    {
        echo "I'm B.\n";
    }
}

// Создатель абстрактного класса
abstract class Creator
{

    // Абстрактный фабричный метод
    abstract protected function FactoryMethod(): Product;

    // метод работы
    public function AnOperation(): Product
    {
        return $this->FactoryMethod();
    }
}

/*
    Между этой и простой фабрикой есть существенная разница:
    мы удалили отвратительный переключатель и позволили каждому
    конкретному классу реализации создавать товарные объекты.
    Правильно, единичный и закрытый.
    Каждый индивидуальный подкласс создателя связан только
    с одним продуктом в заводском методе.
 */

// Создатель реализует класс A
class ConcreteCreatorA extends Creator
{
    // Метод реализации
    protected function FactoryMethod(): Product
    {
        return new ConcreteProductA();
    }
}

// Создатель реализует класс Б
class ConcreteCreatorB extends Creator
{
    // метод
    protected function FactoryMethod(): Product
    {
        return new ConcreteProductB();
    }
}

// Товар А, произведенный фабричным методом А
$factoryA = new ConcreteCreatorA();
$productA = $factoryA->AnOperation();

// Товар Б, произведенный фабричным методом Б
$factoryB = new ConcreteCreatorB();
$productB = $factoryB->AnOperation();

// вызов
$productA->show();
$productB->show();
