<?php

interface Component
{
    public function operation();
}

class ConcreteComponent implements Component
{
    public function operation()
    {
        echo "I'm face!".PHP_EOL;
    }
}

/*
 * Очень простой интерфейс и реализация,
 * здесь мы будем рассматривать конкретный класс реализации как лицо!
*/

abstract class Decorator implements Component
{
    protected $component;

    public function __construct(Component $component)
    {
        $this->component = $component;
    }
}


/*
 * Класс абстрактного декоратора реализует интерфейс Component,
 *  но не реализует метод operation (), позволяя подклассам реализовать его.
 *  Здесь в основном хранится отсылка к Компонету, позже он будет украшен.
 *      В соответствии с конкретной категорией выше,
 *  мы просто собираемся накрасить лицо!
 * */

class ConcreteDecoratorA extends Decorator
{
    /*
     *  Атрибуты, не имеющие практического значения,
     *  просто отличные от ConcreteDecoratorB
     */
    public $addedState = 1;

    public function operation()
    {
        echo $this->component->operation()."Push ".$this->addedState." cream！"
            .PHP_EOL;
    }
}

class ConcreteDecoratorB extends Decorator
{
    public function operation()
    {
        $this->component->operation();
        $this->addedBehavior();
    }

    //     // Практического смысла нет, но она отличается от ConcreteDecoratorA
    public function addedBehavior()
    {
        echo "Push 2 cream！".PHP_EOL;
    }
}

// Украшенный объект
// $component = new ConcreteComponent();
// $component->operation(); // I'm face;

// // Украшаем первый слой
// $component = new ConcreteDecoratorA($component);
// $component->operation(); // I'm face \n Push 1 cream!

// // Украшаем второй слой
// $component = new ConcreteDecoratorB($component);
// $component->operation(); // I'm face \n Push 1 cream! \n Push 2 cream!

// ... Продолжай украшать
//
//   Украшаем все сразу
// Пожалуйста, поставьте три выше $component->operation();
$component2 = new ConcreteComponent(); // face
$component2 = new ConcreteDecoratorA($component2); // face 1
$component2 = new ConcreteDecoratorB($component2); // face 1 2
$component2->operation();
