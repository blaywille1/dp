# singleton / одиночка

У страны может быть только один президент. Он должен действовать, когда того требуют обстоятельства и долг. В данном
случае президент — одиночка.

## AbCD类图及解释

***

- Шаблон позволяет удостовериться, что создаваемый объект — единственный в своём классе.
- гарантирует, что класс имеет ровно один экземпляр и предоставляет к нему глобальную точку доступа.

***

> На самом деле шаблон «Одиночка» считается антипаттерном, не следует им слишком увлекаться. Он необязательно плох и иногда бывает полезен. Но применяйте его с осторожностью, потому что «Одиночка» вносит в приложение глобальное состояние, так что изменение в одном месте может повлиять на все остальные случаи использования, а отлаживать такое — не самое простое занятие. Другие недостатки шаблона: он делает ваш код сильно связанным (tightly coupled), а создание прототипа (mocking) «Одиночки» может быть затруднено.



> AbCD类图

![单例模式](https://raw.githubusercontent.com/blaywille1/dp/master/21.singleton/img/singleton.jpg)

```php
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


```

- Да, как вы можете видеть из кода, наиболее широкое использование синглетонов — сделать наши объекты глобально
  уникальными.
- Так что же хорошего в глобальной уникальности? Некоторые классы дороги в создании и не требуют от нас использования
  каждый раз новых объектов.Они могут быть повторно использованы объектом.У них нет свойств или состояний, которые
  необходимо изменить, а только предоставляют некоторые общие услуги. Например, классы операций с базами данных, классы
  сетевых запросов, классы операций с журналами, службы управления конфигурацией и т. д.
- Один интервьюер однажды спросил, является ли синглтон уникальным в PHP? Если он под процессом, то есть под fpm, то он
  конечно уникален. Это определенно не единственный из множества fpm, который nginx подтягивает синхронно. Один процесс
  один!
- Преимущества одноэлементного шаблона: контролируемый доступ к уникальному экземпляру, уменьшенное пространство имен,
  возможность уточнения операций и представления, допускает переменное количество экземпляров, более гибкий, чем
  операции класса.
- В Laravel шаблон singleton используется в части контейнера IoC. Мы рассмотрим контейнерную часть в следующей серии
  статей о Laravel. Мы можем найти метод singleton в классе Illuminate\Container\Container. Он вызывает метод getClosure
  в методе привязки. Если вы продолжите отслеживать, вы обнаружите, что они в конечном итоге вызовут метод make или
  build контейнера для создания экземпляра класса.Будь то метод make или build, у них будет единственное суждение, то
  есть был создан или уже существует в контейнере. если (!$reflector->isInstantiable()) в build.

**
完整代码：[https://github.com/blaywille1/dp/blob/master/21.singleton/source/singleton.php](https://github.com/blaywille1/dp/blob/master/21.singleton/source/singleton.php)**

## 实例

Поскольку выше было сказано, что класс работы с БД и класс сетевых запросов любят использовать паттерн singleton, то
давайте реализуем разработку паттерна singleton для класса Http-запросов. Помнится, когда я когда-то давно работал на
Android, фреймворков было не так уж и много, HTTP-запросы все инкапсулировались сами по себе, да и большинство
онлайн-туториалов тоже принимали singleton-режим.


> 缓存类图

![缓存模板方法模式版](https://raw.githubusercontent.com/blaywille1/dp/master/21.singleton/img/singleton-http.jpg)

**
完整源码：[https://github.com/blaywille1/dp/blob/master/21.singleton/source/singleton-http.php](https://github.com/blaywille1/dp/blob/master/21.singleton/source/singleton-http.php)**

```php
<?php

class HttpService
{
    private static $instance;

    public function GetInstance()
    {
        if (self::$instance == null) {
            self::$instance = new HttpService();
        }

        return self::$instance;
    }

    public function Post()
    {
        echo 'Отправить post на публикацию
', PHP_EOL;
    }

    public function Get()
    {
        echo 'Отправить get на получение
', PHP_EOL;
    }
}

$httpA = new HttpService();
$httpA->Post();
$httpA->Get();

$httpB = new HttpService();
$httpB->Post();
$httpB->Get();

var_dump($httpA == $httpB);


```

> 说明

> На самом деле шаблон «Одиночка» считается антипаттерном, не следует им слишком увлекаться. Он необязательно плох и иногда бывает полезен. Но применяйте его с осторожностью, потому что «Одиночка» вносит в приложение глобальное состояние, так что изменение в одном месте может повлиять на все остальные случаи использования, а отлаживать такое — не самое простое занятие. Другие недостатки шаблона: он делает ваш код сильно связанным (tightly coupled), а создание прототипа (mocking) «Одиночки» может быть затруднено.

```php
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

```
