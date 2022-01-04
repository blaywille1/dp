<?php

class Sheep
{
    protected $name;
    protected $category;

    public function __construct(
        string $name,
        string $category = 'Mountain Sheep'
    ) {
        $this->name = $name;
        $this->category = $category;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(string $category)
    {
        $this->category = $category;
    }
}

//Затем можно клонировать так:


$original = new Sheep('Jolly');
echo $original->getName(); // Джолли
echo $original->getCategory(); // Горная овечка

// Клонируйте и модифицируйте, что нужно
$cloned = clone $original;
$cloned->setName('Dolly');
echo $cloned->getName(); // Долли
echo $cloned->getCategory(); // Горная овечка

//Также для модификации процедуры клонирования можно обратиться к
// магическому методу __clone.
