<?php

interface Subject
{
    public function Request();
}

class RealSubject implements Subject
{
    function Request()
    {
        echo "Реальная операция", PHP_EOL;
    }
}

class Proxy implements Subject
{
    private $realSubject;

    public function __construct()
    {
        $this->realSubject = new RealSubject();
    }

    public function Request()
    {
        echo "Работа агента", PHP_EOL;
        $this->realSubject->Request();
    }
}

$proxy = new Proxy();
$proxy->Request();

// Удаленный агент: SDK стороннего интерфейса
// Виртуальный прокси: асинхронная загрузка изображений
// Агент защиты и интеллектуальное руководство: Защита разрешений

