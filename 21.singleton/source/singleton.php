<?php

class Singleton
{
    private static $uniqueInstance;
    private $singletonData = 'Внутренние данные синглтона';

    private function __construct()
    {

    }

    public static function GetInstance()
    {
        if (self::$uniqueInstance == null) {
            self::$uniqueInstance = new Singleton();
        }

        return self::$uniqueInstance;
    }

    public function SingletonOperation()
    {
        $this->singletonData
            = 'Измените внутренние данные одноэлементного класса';
    }

    public function GetSigletonData()
    {
        return $this->singletonData;
    }

}

/*
Да, ядро ​​— это такой синглтон-класс, ничего больше.
Пусть статическая переменная содержит экземпляр self.
 Когда этот объект необходим, вызовите метод GetInstance(),
чтобы получить глобально уникальный объект.
*/

// $s = new Singleton;

$singletonA = Singleton::GetInstance();
echo $singletonA->GetSigletonData(), PHP_EOL;

$singletonB = Singleton::GetInstance();

if ($singletonA === $singletonB) {
    echo 'Тот же объект', PHP_EOL;
}
$singletonA->SingletonOperation(); // Модифицировано здесь A

echo $singletonB->GetSigletonData(), PHP_EOL;
