# PHP设计模式之装饰器模式

> Интересно, а вы, ребята, женскую одежду пробовали? Украсим эти два слова, давайте пока превратим его в грим. Сначала нужно нанести лицо, затем основу, а затем нанести макияж.Вы можете нанести легкий макияж утром, чтобы пойти на работу, или вы можете нанести тяжелый макияж, когда вы не работаете и выходите на улицу. Конечно, время, когда кодовые фермеры заканчивают работу, как раз как раз ко второй половине ночного поля. Сказав это, как бы вы ни красились, ваше лицо остается вашим лицом, и оно может превратиться в другого человека, которого никто не знает, но это действительно ваше лицо. Это декоратор, который наносит на объект (лицо) различные украшения (макияж), чтобы лицо выглядело лучше (увеличивать обязанности).

- динамически добавлять некоторые дополнительные обязанности к объекту, с точки зрения добавления функций, режим
  декоратора более гибкий, чем создание подклассов

- Шаблон «Декоратор» позволяет во время выполнения динамически изменять поведение объекта, обёртывая его в объект класса
  «декоратора».

- Шаблон «Декоратор» позволяет подключать к объекту дополнительное поведение (статически или динамически), не влияя на
  поведение других объектов того же класса. Шаблон часто используется для соблюдения принципа единственной обязанности (
  Single Responsibility Principle), поскольку позволяет разделить функциональность между классами для решения конкретных
  задач.

***AbCD定义：动态地给一个对象添加一些额外的职责，就增加功能来说，Decorator模式相比生成子类更为灵活***

![装饰器方法结构类图](https://raw.githubusercontent.com/blaywille1/dp/master/04.decorator/img/decorator.jpg)

```php
<?php

interface Component{
    public function operation();
}

class ConcreteComponent implements Component{
    public function operation(){
        echo "I'm face!" . PHP_EOL;
    }
}
/*
 * Очень простой интерфейс и реализация,
 * здесь мы будем рассматривать конкретный класс реализации как лицо!
*/
abstract class Decorator implements Component{
    protected $component;
    public function __construct(Component $component){
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
class ConcreteDecoratorA extends Decorator{
    /*
     *  Атрибуты, не имеющие практического значения,
     *  просто отличные от ConcreteDecoratorB
     */
    public $addedState = 1;

    public function operation(){
        echo $this->component->operation() . "Push " . $this->addedState . " cream！" . PHP_EOL;
    }
}
class ConcreteDecoratorB extends Decorator{
    public function operation(){
        $this->component->operation();
        $this->addedBehavior();
    }

    //     // Практического смысла нет, но она отличается от ConcreteDecoratorA
    public function addedBehavior(){
        echo "Push 2 cream！" . PHP_EOL;
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

```

- Как видно из кода, мы упаковали конкретный объект ConcreteComponent

- Затем мы фактически дважды обернули его метод operation (), каждый раз добавляя немного на основе предыдущего.

- Не беспокойтесь о добавленных свойствах и методах декораторов A и B. Они используются в диаграмме классов AbCD только
  для того, чтобы различить, что эти два декоратора не одно и то же. Каждый декоратор может делать много других вещей, и
  ни один из них не Компонентный объект. Должен быть только один метод операции (), мы можем выборочно декорировать все
  или часть методов в объекте.

- Кажется, что все мы унаследовали Component, поэтому мы можем полностью переписать подклассы.Почему мы пытаемся это
  сделать? Уважаемый, поймите концепцию композиции, наш родительский класс Decorator - это ссылка на реальный объект,
  отделенный от самого себя, мы только обертываем реальный объект, вы не можете напрямую создать экземпляр декоратора и
  использовать его напрямую

- Все еще не понимаете? Каковы преимущества? Вы смеете менять классы и методы старой системы по своему желанию? Если вы
  хотите расширить новые функции кода, написанного вашим предшественником, вы также можете попробовать декоратор, это
  может быть потрясающе!

> давайте сконцентрируемся на создании чехлов для мобильных телефонов! Ну, сначала я подготовил прозрачную оболочку (Компонент), которая выглядит немного некрасиво, нет никакого способа, кто сказал мне быть бедным. Добавьте различные сплошные цвета (DecoratorA1) к определенному рису, а затем распечатайте растения разных цветов (DecoratorB1) на обратной стороне; мобильный телефон определенного O в последнее время любит находить трафик в качестве четкого подтверждения, тогда я буду использовать множество чехлов для мобильных телефонов для него Ослепительные цвета (DecoratorA2) и мультяшные аватары знаменитостей (DecoratorB2);

##  

- Самое большое преимущество декораторов: во-первых, содержимое исходного кода расширяется без изменения исходного кода
  и принципа открытости и закрытия; во-вторых, каждый декоратор выполняет свою собственную функцию и несет единственную
  ответственность; в-третьих, это реализуется с помощью сочетание Чувство наследственности

- Подходит для: расширения старой системы

- Будьте осторожны: слишком много декораторов запутают вас

- Не всегда необходимо украшать один и тот же метод. На самом деле, декораторы следует больше использовать для украшения
  и расширения объектов. Здесь мы все украшаем выходные данные метода, но только в этой статье декоратор на самом деле
  более широко используется

- Особенностью декораторов является то, что все они наследуются от основного интерфейса или класса. Преимущество этого
  заключается в том, что возвращаемый объект представляет собой одни и те же абстрактные данные и имеет те же свойства
  поведения. В противном случае это не объект до украшения, а объект новый объект

```php
<?php


//Возьмём в качестве примера кофе. Сначала просто реализуем интерфейс:


interface Coffee
{
    public function getCost();

    public function getDescription();
}

class SimpleCoffee implements Coffee
{
    public function getCost()
    {
        return 10;
    }

    public function getDescription()
    {
        return 'Simple coffee';
    }
}

//Можно сделать код расширяемым, чтобы при необходимости вносить
// модификации. Добавим «декораторы»:


class MilkCoffee implements Coffee
{
    protected $coffee;

    public function __construct(Coffee $coffee)
    {
        $this->coffee = $coffee;
    }

    public function getCost()
    {
        return $this->coffee->getCost() + 2;
    }

    public function getDescription()
    {
        return $this->coffee->getDescription().', milk';
    }
}

class WhipCoffee implements Coffee
{
    protected $coffee;

    public function __construct(Coffee $coffee)
    {
        $this->coffee = $coffee;
    }

    public function getCost()
    {
        return $this->coffee->getCost() + 5;
    }

    public function getDescription()
    {
        return $this->coffee->getDescription().', whip';
    }
}

class VanillaCoffee implements Coffee
{
    protected $coffee;

    public function __construct(Coffee $coffee)
    {
        $this->coffee = $coffee;
    }

    public function getCost()
    {
        return $this->coffee->getCost() + 3;
    }

    public function getDescription()
    {
        return $this->coffee->getDescription().', vanilla';
    }
}

//Теперь приготовим кофе:


$someCoffee = new SimpleCoffee();
echo $someCoffee->getCost(); // 10
echo $someCoffee->getDescription(); // Simple Coffee

$someCoffee = new MilkCoffee($someCoffee);
echo $someCoffee->getCost(); // 12
echo $someCoffee->getDescription(); // Simple Coffee, milk

$someCoffee = new WhipCoffee($someCoffee);
echo $someCoffee->getCost(); // 17
echo $someCoffee->getDescription(); // Simple Coffee, milk, whip

$someCoffee = new VanillaCoffee($someCoffee);
echo $someCoffee->getCost(); // 20
echo $someCoffee->getDescription(); // Simple Coffee, milk, whip, vanilla

```
