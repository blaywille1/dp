<?php

interface Door
{
    public function getDescription();
}

interface DoorFittingExpert
{
    public function getDescription();
}

interface DoorFactory
{
    public function makeDoor(): Door;

    public function makeFittingExpert(): DoorFittingExpert;
}

//Теперь нам нужны специалисты по установке каждого вида дверей.

class WoodenDoor implements Door
{
    public function getDescription()
    {
        echo 'I am a wooden door';
    }
}

class IronDoor implements Door
{
    public function getDescription()
    {
        echo 'I am an iron door';
    }
}

class Welder implements DoorFittingExpert
{
    public function getDescription()
    {
        echo 'I can only fit iron doors';
    }
}

/*
Мы получили абстрактную фабрику, которая позволяет создавать семейства
объектов или взаимосвязанные объекты. То есть фабрика деревянных
дверей создаст деревянную дверь и человека для её монтажа,
фабрика стальных дверей — стальную дверь
и соответствующего специалиста и т. д.
*/

class Carpenter implements DoorFittingExpert
{
    public function getDescription()
    {
        echo 'I can only fit wooden doors';
    }
}

// Фабрика деревянных дверей возвращает плотника и деревянную дверь

class WoodenDoorFactory implements DoorFactory
{
    public function makeDoor(): Door
    {
        return new WoodenDoor();
    }

    public function makeFittingExpert(): DoorFittingExpert
    {
        return new Carpenter();
    }
}

// Фабрика стальных дверей возвращает стальную дверь и сварщика
class IronDoorFactory implements DoorFactory
{
    public function makeDoor(): Door
    {
        return new IronDoor();
    }

    public function makeFittingExpert(): DoorFittingExpert
    {
        return new Welder();
    }
}

$woodenFactory = new WoodenDoorFactory();

$door = $woodenFactory->makeDoor();
$expert = $woodenFactory->makeFittingExpert();

$door->getDescription();  // Output: Я деревянная дверь
$expert->getDescription(); // Output: Я могу устанавливать только деревянные двери

// Same for Iron Factory
$ironFactory = new IronDoorFactory();

$door = $ironFactory->makeDoor();
$expert = $ironFactory->makeFittingExpert();

$door->getDescription();  // Output: Я стальная дверь
$expert->getDescription(); // Output: Я могу устанавливать только стальные двери
/*
Здесь фабрика деревянных дверей инкапсулировала carpenter и wooden door,
фабрика стальных дверей — iron door and welder.
То есть можно быть уверенными, что для каждой из созданных дверей
мы получим правильного специалиста.
*/
