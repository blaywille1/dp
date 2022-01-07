<?php

//Сделайте конструктор приватным,
// отключите расширения и создайте статическую переменную
// для хранения экземпляра:


final class President
{
    private static $instance;

    private function __construct()
    {
        // Прячем конструктор
    }

    public static function getInstance(): President
    {
        if ( ! self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __clone()
    {
        // Отключаем клонирование
    }

    private function __wakeup()
    {
        // Отключаем десериализацию
    }
}

//Использование:


$president1 = President::getInstance();
$president2 = President::getInstance();

var_dump($president1 === $president2); // true
