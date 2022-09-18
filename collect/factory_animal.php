<?php

/**
 * All animal should extend this abstract animal class
 */
abstract class AnimalAbstract
{
    protected $species;

    public function getSpecies() {
        return $this->species;
    }
}

/**
 * used to represent a cat
 */
class Cat extends AnimalAbstract
{
    protected $species = 'cat';
}

/**
 * used to represent a dog
 */
class Dog extends AnimalAbstract
{
    protected $species = 'dog';
}

/**
 * used to represent a pig
 */
class Pig extends AnimalAbstract
{
    protected $species = 'pig';
}

/**
 * used to represent a chicken
 */
class Chicken extends AnimalAbstract
{
    protected $species = 'chicken';
}

/**
 * used to represent a zebra
 */
class Zebra extends AnimalAbstract
{
    protected $species = 'zebra';
}

/**
 * used to represent a giraffe
 */
class Giraffe extends AnimalAbstract
{
    protected $species = 'giraffe';

    public function test(): void
    {
    }
}

/**
 * used to represent a all factories should implement this interface
 */
interface AnimalFactoryInterface
{
    public static function factory($animal);
}

/**
 * this should be used to create all animals which are pets
 */
class PetAnimalFactory implements AnimalFactoryInterface
{
    public static function factory($animal)
    {
        switch ($animal) {
            case 'cat':
                $obj = new Cat();
                break;
            case 'dog':
                $obj = new Dog();
                break;
            default:
                throw new Exception("Pet animal factory could not create animal of species '" . $animal . "'", 1000);
        }
        return $obj;
    }
}

/**
 * this should be used to create all animals which are farm animals
 */
class FarmAnimalFactory implements AnimalFactoryInterface
{
    public static function factory($animal)
    {
        switch ($animal) {
            case 'pig':
                $obj = new Pig();
                break;
            case 'chicken':
                $obj = new Chicken();
                break;
            default:
                throw new Exception("Farm animal factory could not create animal of species '" . $animal . "'", 1000);
        }
        return $obj;
    }
}

/**
 * this should be used to create all animals which are safari animals
 */
class SafariAnimalFactory implements AnimalFactoryInterface
{
    public static function factory($animal)
    {
        switch ($animal) {
            case 'zebra':
                $obj = new Zebra();
                break;
            case 'giraffe':
                $obj = new Giraffe();
                break;
            default:
                throw new Exception("Safari animal factory could not create animal of species '" . $animal . "'", 1000);
        }
        return $obj;
    }
}

try {

    $cat = PetAnimalFactory::factory('cat'); // object(Cat)#1
    echo $cat->getSpecies(); // cat

    $pig = FarmAnimalFactory::factory('pig'); // object(Pig)#1
    echo $pig->getSpecies(); // pig

    $giraffe = SafariAnimalFactory::factory('giraffe'); // object(Giraffe)#1
    echo $giraffe->getSpecies(); // giraffe

    $petChicken = PetAnimalFactory::factory('chicken'); // This will throw an Exception

} catch(Exception $e) {
    echo $e->getMessage(); // PetAnimalFactory could not create animal of species 'chicken'
}
