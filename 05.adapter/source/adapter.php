<?php

interface Target
{
    function Request(): void;
}

//Определите контракт интерфейса или это может быть обычный класс
// с методами реализации (мы будем использовать классы в следующих примерах)

class Adapter implements Target
{
    private $adaptee;

    function __construct($adaptee)
    {
        $this->adaptee = $adaptee;
    }

    function Request(): void
    {
        $this->adaptee->SpecificRequest();
    }
}

//Адаптер реализует этот интерфейсный контракт, позволяя реализовать
// метод Request (), но обратите внимание, что на самом деле
// мы вызываем метод в классе Adaptee.

class Adaptee
{
    function SpecificRequest(): void
    {
        echo "I'm China Standard！";
    }
}

// Я клиент
$adaptee = new Adaptee();
$adapter = new Adapter($adaptee);
$adapter->Request();
