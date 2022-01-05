<?php

//Представим себе охотника на львов.

//Создадим интерфейс Lion, который реализует все типы львов.

interface Lion
{
    public function roar();
}

class AfricanLion implements Lion
{
    public function roar()
    {
    }
}

class AsianLion implements Lion
{
    public function roar()
    {
    }
}

//Охотник должен охотиться на все реализации интерфейса Lion.

class Hunter
{
    public function hunt(Lion $lion)
    {
    }
}

//Добавим теперь дикую собаку WildDog, на которую охотник тоже может охотиться. Но у нас не получится сделать это напрямую, потому что у собаки другой интерфейс. Чтобы она стала совместима с охотником, нужно создать подходящий адаптер.

// Это нужно добавить
class WildDog
{
    public function bark()
    {
    }
}

// Адаптер вокруг собаки сделает её совместимой с охотником
class WildDogAdapter implements Lion
{
    protected $dog;

    public function __construct(WildDog $dog)
    {
        $this->dog = $dog;
    }

    public function roar()
    {
        $this->dog->bark();
    }
}

//Теперь WildDog может вступить в игру действие благодаря WildDogAdapter.

$wildDog = new WildDog();
$wildDogAdapter = new WildDogAdapter($wildDog);

$hunter = new Hunter();
$hunter->hunt($wildDogAdapter);
