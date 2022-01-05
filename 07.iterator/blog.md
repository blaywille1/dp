> Когда дело доходит до этого режима, мы должны упомянуть операторы цикла. В режиме «Big Talk Design Mode» автор сказал, что обучающая значимость этой модели теперь больше, чем практическая значимость. Почему это так? Конечно, это было сделано с помощью foreach. В любом языке есть подобная грамматика, позволяющая легко и быстро перемещаться по массивам и объектам, так что режим итератора постепенно превратился в прохожего из звезды 23 лучших шаблонов проектирования. Особенно наш язык PHP. Сила PHP заключается в гибкости работы с массивами. Это структура хэш-карты. Естественно, существуют различные удобные синтаксисы операций с массивами. Foreach также является нашим наиболее часто используемым оператором, даже лучше, чем для Также часто используется .

> Хороший пример — радиоприёмник. Вы начинаете с какой-то радиостанции, а затем перемещаетесь по станциям вперёд/назад. То есть устройство предоставляет интерфейс для итерирования по каналам.

## AbCD类图及解释

***

- предоставить метод для последовательного доступа к каждому элементу агрегированного объекта без раскрытия внутреннего
  представления объекта
- Шаблон — это способ доступа к элементам объекта без раскрытия базового представления.

*** 

> AbCD类图

![迭代器模式](https://raw.githubusercontent.com/blaywille1/dp/master/07.iterator/img/iterator.jpg)

- Всем должно быть очень любопытно, почему наш класс интерфейса итератора не называется Iterator? Постарайтесь узнать,
  что PHP подготовил для нас этот интерфейс. После реализации вы можете использовать foreach для использования этого
  класса, реализующего интерфейс Iterator. Он очень большой? Наконец, мы рассмотрим использование этого класса.

```php
<?php

interface MyIterator
{
    public function First();

    public function Next();

    public function IsDone();

    public function CurrentItem();
}

// Первый - это класс агрегирования, то есть класс, который может
// быть повторен. Здесь, поскольку я являюсь объектно-ориентированным
// шаблоном проектирования, шаблон итератора нацелен на повторение
// содержимого класса. Здесь, по сути, мы просто смоделировали массив и
// передали его итератору.

interface Aggregate
{
    public function CreateIterator();
}

class ConcreteIterator implements MyIterator
{
    private $list;
    private $index;

    public function __construct($list)
    {
        $this->list = $list;
        $this->index = 0;
    }

    public function First()
    {
        $this->index = 0;
    }

    public function Next()
    {
        $this->index++;
    }

    public function IsDone()
    {
        return $this->index >= count($this->list);
    }

    public function CurrentItem()
    {
        return $this->list[$this->index];
    }
}

class ConcreteAggregate implements Aggregate
{
    public function CreateIterator()
    {
        $list = [
            "a",
            "b",
            "c",
            "d",
        ];

        return new ConcreteIterator($list);
    }
}

// На сцене появляется итератор, который в основном реализует четыре
// метода для работы с данными коллекции. Это немного похоже на операцию,
// выполняемую над курсором при изучении структуры данных или базы данных.
// Используйте First () и Next (), чтобы переместить курсор, используйте
// CurrentItem (), чтобы получить содержимое данных текущего курсора,
// и используйте IsDone (), чтобы подтвердить, есть ли еще один
// фрагмент данных. Поэтому этот режим еще называют режимом курсора .

$agreegate = new ConcreteAggregate();
$iterator = $agreegate->CreateIterator();

while ( ! $iterator->IsDone()) {
    echo $iterator->CurrentItem(), PHP_EOL;
    $iterator->Next();
}

$iterator->First();
echo $iterator->CurrentItem(), PHP_EOL;
$iterator->Next();
echo $iterator->CurrentItem(), PHP_EOL;

```

**
完整代码：[https://github.com/blaywille1/dp/blob/master/07.iterator/source/iterator.php](https://github.com/blaywille1/dp/blob/master/07.iterator/source/iterator.php)**

![消息发送迭代器](https://raw.githubusercontent.com/blaywille1/dp/master/07.iterator/img/iterator-msg.jpg)

**
完整源码：[https://github.com/blaywille1/dp/blob/master/07.iterator/source/iterator-msg.php](https://github.com/blaywille1/dp/blob/master/07.iterator/source/iterator-msg.php)**

```php
<?php

//В PHP довольно легко реализовать этот шаблон с помощью
// стандартной библиотеки PHP. Сначала создадим радиостанцию RadioStation.


class RadioStation
{
    protected $frequency;

    public function __construct(float $frequency)
    {
        $this->frequency = $frequency;
    }

    public function getFrequency(): float
    {
        return $this->frequency;
    }
}

//Теперь создадим итератор:


use Countable;
use Iterator;

class StationList implements Countable, Iterator
{
    /** @var RadioStation[] $stations */
    protected $stations = [];

    /** @var int $counter */
    protected $counter;

    public function addStation(RadioStation $station)
    {
        $this->stations[] = $station;
    }

    public function removeStation(RadioStation $toRemove)
    {
        $toRemoveFrequency = $toRemove->getFrequency();
        $this->stations = array_filter($this->stations,
            function (RadioStation $station) use ($toRemoveFrequency) {
                return $station->getFrequency() !== $toRemoveFrequency;
            });
    }

    public function count(): int
    {
        return count($this->stations);
    }

    public function current(): RadioStation
    {
        return $this->stations[$this->counter];
    }

    public function key()
    {
        return $this->counter;
    }

    public function next()
    {
        $this->counter++;
    }

    public function rewind()
    {
        $this->counter = 0;
    }

    public function valid(): bool
    {
        return isset($this->stations[$this->counter]);
    }
}

//Использование:


$stationList = new StationList();

$stationList->addStation(new RadioStation(89));
$stationList->addStation(new RadioStation(101));
$stationList->addStation(new RadioStation(102));
$stationList->addStation(new RadioStation(103.2));

foreach ($stationList as $station) {
    echo $station->getFrequency().PHP_EOL;
}

$stationList->removeStation(new RadioStation(89));
// Will remove station 89

```
