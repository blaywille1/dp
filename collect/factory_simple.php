<?php
/*
SimpleFactory is a simple factory pattern.
It differs from the static factory because it is not static.
Therefore, you can have multiple factories, differently parameterized, you can subclass it and you can mock it.
It always should be preferred over a static factory!
*/

class Bicycle
{
    public function driveTo(string $destination)
    {
    }
}

class SimpleFactory
{
    public function createBicycle(): Bicycle
    {
        return new Bicycle();
    }
}


// usage
$factory = new SimpleFactory();
$bicycle = $factory->createBicycle();
$bicycle->driveTo('Paris');
