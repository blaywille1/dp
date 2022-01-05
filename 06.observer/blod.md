Наблюдатель, кажется, эта роль фигурирует во многих произведениях фантастики. Например, в американской драме «На грани
кризиса», которая мне очень нравится, в этом эпизоде ​​наблюдатели постоянно путешествуют во времени и пространстве,
чтобы запечатлеть различных людей и события. Однако наблюдатель в шаблоне проектирования не просто стоит сбоку, чтобы
наблюдать, наблюдатель здесь должен совершать соответствующие действия в ответ на изменение состояния объекта.

Хороший пример: люди, ищущие работу, подписываются на публикации на сайтах вакансий и получают уведомления, когда
появляются вакансии, подходящие по параметрам.

## AbCD类图及解释

***Шаблон определяет зависимость между объектами, чтобы при изменении состояния одного из них его «подчинённые» узнавали
об этом.

***

> AbCD类图

![适配器方法结构类图-继承式](https://raw.githubusercontent.com/blaywille1/dp/master/06.observer/img/observer.jpg)

```php
<?php

interface Observer
{
    public function update(Subject $subject): void;
}

//Об абстрактном интерфейсе наблюдателя нечего сказать, просто
// позвольте вам реализовать конкретное обновление.
class ConcreteObserver implements Observer
{
    private $observerState = '';

    function update(Subject $subject): void
    {
        $this->observerState = $subject->getState();
        echo 'Выполните операцию наблюдателя! Текущее состояние：'
            .$this->observerState;
    }
}

//Конкретный наблюдатель реализует метод update (), в котором мы получаем класс Subject,
// чтобы можно было получить статус
class Subject
{
    protected $stateNow = '';
    private $observers = [];

    public function attach(Observer $observer): void
    {
        array_push($this->observers, $observer);
    }

    public function detach(Observer $observer): void
    {
        $position = 0;
        foreach ($this->observers as $ob) {
            if ($ob == $observer) {
                array_splice($this->observers, ($position), 1);
            }
            ++$position;
        }
    }

    public function notify(): void
    {
        foreach ($this->observers as $ob) {
            $ob->update($this);
        }
    }
}

// Родительский класс Subject поддерживает массив наблюдателей,
// а затем есть методы для добавления, удаления и цикла по массиву.
// Цель состоит в том, чтобы удобно управлять всеми наблюдателями.

class ConcreteSubject extends Subject
{
    public function setState($state)
    {
        $this->stateNow = $state;
        $this->notify();
    }

    public function getState()
    {
        return $this->stateNow;
    }
}

$observer = new ConcreteObserver();
$observer2 = new ConcreteObserver();
$subject = new ConcreteSubject();
$subject->attach($observer);

// $subject->setState('Ха-ха-ха-ха');
// $subject->detach($observer);
// $subject->setState('Хахахаха 222');

$subject->attach($observer2);
$subject->setState('Ха-ха-ха-ха');

//Класс реализации Subject только обновляет состояние.
//При изменении состояния вызывается метод обхода наблюдателя
// для выполнения операции update () для всех наблюдений.


```

## 实例

- Наблюдатель на самом деле является обновлением (обновлением) сам по себе, и субъект может запускать наблюдателей
  партиями. Обратите внимание, что нам не нужно изменять какой-либо код в целевом классе, просто добавьте его извне,
  поэтому просто позвольте цели и наблюдатель разъединяют друг друга, не заботясь о ситуации друг друга
- В шаблоне наблюдателя все еще существует связь, то есть в целевом классе есть список объектов-наблюдателей. Если
  наблюдатель не реализует метод update (), возникнут проблемы.

> 订单售出类图

![订单售出观察者模式](https://raw.githubusercontent.com/blaywille1/dp/master/06.observer/img/order-observer.jpg)

В этот раз мы начали с заказа, но SMS-сообщения остались. Когда заказ размещается на общей платформе электронной
коммерции, необходимо выполнить множество действий, например изменить инвентарь, отправить текстовое сообщение или
нажать кнопку push, чтобы сообщить продавцу, что кто-то разместил заказ, и сообщить об этом покупатель, что заказ
успешен и оплата прошла успешно. Короче говоря, возникновение чего-то одного приведет к разным событиям. Фактически, вот
еще одна очень известная модель публикации по подписке . Эту модель можно назвать моделью обновления для
наблюдателей.Эта серия статей не будет вдаваться в подробности, но вы можете перейти к просмотру содержимого публикации
и подписки и мониторинга событий в Laravel .

```php
<?php

interface Observer
{
    public function update($obj);
}

class Message implements Observer
{
    //....

    function update($obj)
    {
        echo 'Отправить текстовое сообщение о новом заказе
('.$obj->mobile.')Уведомить продавца！';
    }

    //....
}

class Goods implements Observer
{
    //....

    public function update($obj)
    {
        echo 'Изменить продукт
'.$obj->goodsId.'Инвентарь！';
    }

    //....
}

class Order
{
    private $observers = [];

    public function attach($ob)
    {
        $this->observers[] = $ob;
    }

    public function detach($ob)
    {
        $position = 0;
        foreach ($this->observers as $ob) {
            if ($ob == $observer) {
                array_splice($this->observers, ($position), 1);
            }
            ++$position;
        }
    }

    public function sale()
    {
        // Товар продан
        // ....
        $obj = new stdClass();
        $obj->mobile = '13888888888';
        $obj->goodsId = 'Order11111111';
        $this->notify($obj);
    }

    public function notify($obj)
    {
        foreach ($this->observers as $ob) {
            $ob->update($obj);
        }
    }
}

$message = new Message();
$goods = new Goods();
$order = new Order();
$order->attach($message);
$order->attach($goods);

// Заказ продан! !
$order->sale();

```

> 说明

- Мы не полностью соблюдали диаграмму классов AbCD. Хотя AbCD - это библия, это не то, что мы должны полностью
  соблюдать. Мы можем адаптировать ее к конкретным бизнес-ситуациям.
- После изменения статуса заказа с помощью метода sale () вызовите метод notify для вызова наблюдателя.
- Отправка текстовых сообщений и отправка push-сообщений могут быть реализованы отдельными наблюдателями.Эти наблюдатели
  могут иметь не только этот метод, но им нужно только реализовать общий интерфейс.
- Инвентаризация товаров и отправка сообщений - это на самом деле два класса, которые сами по себе совершенно не
  затронуты, но им нужно только реализовать один и тот же интерфейс.
- Набор интерфейсов наблюдателя был подготовлен для нас в расширении SPL PHP. Вы можете попробовать его. Использование
  режима наблюдателя, поддерживаемого изначально, может сэкономить массу проблем!

```php
<?php

// Используйте пакет функций расширения spl в php
// SplSubject，Объект-наблюдатель
// SplObserver，Наблюдатель
// SplObjectStorage，Объект хранения
// http://www.php.net/manual/zh/book.spl.php

class ConcreteSubject implements SplSubject
{
    private $observers;
    private $data;

    public function setObservers()
    {
        $this->observers = new SplObjectStorage();
    }

    public function attach(SplObserver $observer)
    {
        $this->observers->attach($observer);
    }
    public function detach(SplObserver $observer)
    {
        $this->observers->detach($observer);
    }
    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
    public function setData($dataNow)
    {
        $this->data = $dataNow;
    }
    public function getData()
    {
        return $this->data;
    }
}

class ConcreteObserver implements SplObserver
{
    public function update(SplSubject $subject)
    {
        echo $subject->getData() . PHP_EOL;
    }
}

class Client
{
    public function __construct()
    {
        $ob1 = new ConcreteObserver();
        $ob2 = new ConcreteObserver();
        $ob3 = new ConcreteObserver();

        $subject = new ConcreteSubject();
        $subject->setObservers();
        $subject->setData("Here's your data!");
        $subject->attach($ob1);
        $subject->attach($ob2);
        $subject->attach($ob3);
        $subject->notify();

        $subject->detach($ob3);
        $subject->notify();

        $subject->setData("More data that only ob1 and ob3 need.");
        $subject->detach($ob3);
        $subject->attach($ob2);
        $subject->notify();

    }
}

$worker = new Client();

```
