<?php

//Возьмём зоопарк: у нас есть несколько видов животных,
// и нам нужно послушать издаваемые ими звуки.


// Место посещения
interface Animal
{
    public function accept(AnimalOperation $operation);
}

// Посетитель
interface AnimalOperation
{
    public function visitMonkey(Monkey $monkey);

    public function visitLion(Lion $lion);

    public function visitDolphin(Dolphin $dolphin);
}

//Реализуем животных:


class Monkey implements Animal
{
    public function shout()
    {
        echo 'Ooh oo aa aa!';
    }

    public function accept(AnimalOperation $operation)
    {
        $operation->visitMonkey($this);
    }
}

class Lion implements Animal
{
    public function roar()
    {
        echo 'Roaaar!';
    }

    public function accept(AnimalOperation $operation)
    {
        $operation->visitLion($this);
    }
}

class Dolphin implements Animal
{
    public function speak()
    {
        echo 'Tuut tuttu tuutt!';
    }

    public function accept(AnimalOperation $operation)
    {
        $operation->visitDolphin($this);
    }
}

//Реализуем посетителя:


class Speak implements AnimalOperation
{
    public function visitMonkey(Monkey $monkey)
    {
        $monkey->shout();
    }

    public function visitLion(Lion $lion)
    {
        $lion->roar();
    }

    public function visitDolphin(Dolphin $dolphin)
    {
        $dolphin->speak();
    }
}

//Использование:


$monkey = new Monkey();
$lion = new Lion();
$dolphin = new Dolphin();

$speak = new Speak();

$monkey->accept($speak);    // Уа-уа-уааааа!
$lion->accept($speak);      // Ррррррррр!
$dolphin->accept($speak);   // Туут тутт туутт!

//Это можно было сделать просто с помощью иерархии наследования,
// но тогда пришлось бы модифицировать животных при каждом добавлении
// к ним новых действий. А здесь менять их не нужно. Например,
// мы можем добавить животным прыжки, просто создав нового посетителя:


class Jump implements AnimalOperation
{
    public function visitMonkey(Monkey $monkey)
    {
        echo 'Jumped 20 feet high! on to the tree!';
    }

    public function visitLion(Lion $lion)
    {
        echo 'Jumped 7 feet! Back on the ground!';
    }

    public function visitDolphin(Dolphin $dolphin)
    {
        echo 'Walked on water a little and disappeared';
    }
}

//Использование:


$jump = new Jump();

$monkey->accept($speak);   // Ooh oo aa aa!
$monkey->accept($jump);    // Jumped 20 feet high! on to the tree!

$lion->accept($speak);     // Roaaar!
$lion->accept($jump);      // Jumped 7 feet! Back on the ground!

$dolphin->accept($speak);  // Tuut tutt tuutt!
$dolphin->accept($jump);   // Walked on water a little and disappeared
