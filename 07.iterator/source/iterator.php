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
