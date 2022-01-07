# FaCade / Фасад

Фасадный режим, также называемый режимом внешнего вида. Будь то фасад или внешний вид, это наша среда для внешнего мира,
как и наше лицо. Поэтому самая большая особенность этой модели — быть «красивой». как сказать? Куча сложных вызовов
объектов меня смущает, особенно при обновлении и обслуживании старой системы. Используя фасад для инкапсуляции вызовов
функций старой системы, он выглядит так же, как и новая система снаружи.Это цель режима фасада!

> Как включить компьютер? Вы скажете: «Нажать кнопку включения». Это потому, что вы используете простой интерфейс, предоставляемый компьютером наружу. А внутри него происходит очень много процессов. Простой интерфейс для сложной подсистемы — это фасад.

## AbCD类图及解释

***
Чтобы обеспечить согласованный интерфейс для набора интерфейсов в подсистеме, шаблон Facade определяет высокоуровневый
интерфейс, упрощающий использование этой подсистемы.
***

> AbCD类图

![门面模式](https://raw.githubusercontent.com/blaywille1/dp/master/19.facade/img/facade.jpg)

```php
<?php


/*
Об определении четырех и более подсистем и говорить нечего,
можно представить, что подсистем много, и они не обязательно такие же,
как эти четыре подсистемы, но могут быть очень разными.
*/
class Facade
{

    private $subStytemOne;
    private $subStytemTwo;
    private $subStytemThree;
    private $subStytemFour;
    public function __construct()
    {
        $this->subSystemOne = new SubSystemOne();
        $this->subSystemTwo = new SubSystemTwo();
        $this->subSystemThree = new SubSystemThree();
        $this->subSystemFour = new SubSystemFour();
    }

    public function MethodA()
    {
        $this->subSystemOne->MethodOne();
        $this->subSystemTwo->MethodTwo();
    }
    public function MethodB()
    {
        $this->subSystemOne->MethodOne();
        $this->subSystemTwo->MethodTwo();
        $this->subSystemThree->MethodThree();
        $this->subSystemFour->MethodFour();
    }
}

class SubSystemOne
{
    public function MethodOne()
    {
        echo 'Подсистема Метод первый
', PHP_EOL;
    }
}
class SubSystemTwo
{
    public function MethodTwo()
    {
        echo 'Подсистема, метод второй
', PHP_EOL;
    }
}
class SubSystemThree
{
    public function MethodThree()
    {
        echo 'Подсистема, метод третий
', PHP_EOL;
    }
}
class SubSystemFour
{
    public function MethodFour()
    {
        echo 'Подсистема, метод четвертый
', PHP_EOL;
    }
}

// Эти подсистемы упакованы классом фасада, и только
// вновь определенные методы фасада предоставляются внешнему миру.
$facade = new Facade();
$facade->MethodA();
$facade->MethodB();

```

Вызов клиента очень прост, нам не нужно знать, какие подсистемы вызываются, нам нужно только знать, что делают эти
методы фасада!

- Фасадный режим настолько прост, и, поскольку это настоящий друг, который занимался разработкой проекта, он, должно
  быть, использовал этот режим по незнанию.
- Шаблон Facade полезен, когда вам нужно предоставить простой интерфейс для сложной подсистемы. В то же время, если
  существует большая зависимость между клиентской программой и частью реализации абстрактного класса, можно также ввести
  шаблон фасада, чтобы отделить и улучшить независимость и ремонтопригодность подсистемы. Во-вторых, когда вам нужно
  построить иерархию подсистем, фасад может выступать в качестве точки входа для каждого уровня подсистем.
- Считается, что фасадная система в Laravel использовалась людьми, которые использовали фреймворк, например: Cache::
  put(). В Laravel фасады реализованы с помощью магического метода __callStatic(). Тогда пусть метод объекта можно
  вызвать напрямую, используя статический метод. Разве это не удивительно. Заинтересованные друзья могут просмотреть
  исходный код, который находится в /Illuminate/Support/Facades/Facade.php.
- Фокус: Трехуровневая структура или MVC также является воплощением шаблона фасада. Как упоминалось выше, шаблон фасада
  подходит для обслуживания иерархических подсистем. Трехуровневая структура, MVC, MVP и MVVM, по существу,
  предназначена для многоуровневой структуры, а цель многоуровневой структуры — уменьшить сложность системы.

*Недостаточно просто продавать наши мобильные телефоны, наша конечная цель - стать высокотехнологичной компанией по
производству бытовой техники, такой как X Meter. Тем не менее, мы не можем производить так много бытовой техники,
поэтому мы решили сделать торговый центр (Фасад), чтобы позволить некоторым очень качественным торговцам присоединиться
к нашему лагерю и разместить свою продукцию (Подсистема) в торговом центре для совместной продажи. Конечно, эти продукты
были тщательно отобраны нами, и они, безусловно, лучшие из лучших! !
> Как включить компьютер? Вы скажете: «Нажать кнопку включения». Это потому, что вы используете простой интерфейс, предоставляемый компьютером наружу. А внутри него происходит очень много процессов. Простой интерфейс для сложной подсистемы — это фасад.

*

**
完整代码：[https://github.com/blaywille1/dp/blob/master/19.facade/source/facade.php](https://github.com/blaywille1/dp/blob/master/19.facade/source/facade.php)**

![短信发送功能门面模式版](https://raw.githubusercontent.com/blaywille1/dp/master/19.facade/img/facade-push.jpg)

**
完整源码：[https://github.com/blaywille1/dp/blob/master/19.facade/source/facade-push.php](https://github.com/blaywille1/dp/blob/master/19.facade/source/facade-push.php)**

> Как включить компьютер? Вы скажете: «Нажать кнопку включения». Это потому, что вы используете простой интерфейс, предоставляемый компьютером наружу. А внутри него происходит очень много процессов. Простой интерфейс для сложной подсистемы — это фасад. Шаблон «Фасад» предоставляет упрощённый интерфейс для сложной подсистемы.

```php
<?php

//Создадим класс computer:


class Computer
{
    public function getElectricShock()
    {
        echo "Ouch!";
    }

    public function makeSound()
    {
        echo "Beep beep!";
    }

    public function showLoadingScreen()
    {
        echo "Loading..";
    }

    public function bam()
    {
        echo "Ready to be used!";
    }

    public function closeEverything()
    {
        echo "Bup bup bup buzzzz!";
    }

    public function sooth()
    {
        echo "Zzzzz";
    }

    public function pullCurrent()
    {
        echo "Haaah!";
    }
}

//Теперь «фасад»:


class ComputerFacade
{
    protected $computer;

    public function __construct(Computer $computer)
    {
        $this->computer = $computer;
    }

    public function turnOn()
    {
        $this->computer->getElectricShock();
        $this->computer->makeSound();
        $this->computer->showLoadingScreen();
        $this->computer->bam();
    }

    public function turnOff()
    {
        $this->computer->closeEverything();
        $this->computer->pullCurrent();
        $this->computer->sooth();
    }
}

//Использование:


$computer = new ComputerFacade(new Computer());
$computer->turnOn(); // Ouch! Beep beep! Loading.. Ready to be used!
$computer->turnOff(); // Bup bup buzzz! Haah! Zzzzz

```
