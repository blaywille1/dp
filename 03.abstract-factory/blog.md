##  

**Предоставление интерфейса для создания серии связанных или взаимозависимых объектов без указания для них конкретных
классов**

Когда использовать? Когда у вас есть взаимосвязи с не самой простой логикой создания (creation logic).

> - Шаблон «Абстрактная фабрика» описывает способ инкапсулирования группы индивидуальных фабрик (серии связанных или взаимозависимых объектов) , объединённых некой темой, без указания для них конкретных классов.
>
> - Шаблон Абстрактная фабрика - Это фабрика фабрик. То есть фабрика, группирующая индивидуальные, но взаимосвязанные/взаимозависимые фабрики без указания для них конкретных классов.



![Схема классов](https://raw.githubusercontent.com/blaywille1/dp/master/03.abstract-factory/img/abstract-factory.jpg)

- Слева две фабрики 1 и 2, обе наследуют абстрактную фабрику и обе реализуют методы CreateProductA и CreateProductB.
- Завод 1 производит ProductA1 и ProductB1
- Аналогичным образом Factory 2 производит ProductA2 и ProductB2.

>

```php
<?php

//  продукт Абстрактный интерфейс
interface AbstractProductA
{
    public function show(): void;
}

// Товар А1 релизует
class ProductA1 implements AbstractProductA
{
    public function show(): void
    {
        echo 'ProductA1 is Show!'.PHP_EOL;
    }
}

// Реализация товара А2
class ProductA2 implements AbstractProductA
{
    public function show(): void
    {
        echo 'ProductA2 is Show!'.PHP_EOL;
    }
}

// Продукт Б абстрактный интерфейс
interface AbstractProductB
{
    public function show(): void;
}

// Реализация товара Б1
class ProductB1 implements AbstractProductB
{
    public function show(): void
    {
        echo 'ProductB1 is Show!'.PHP_EOL;
    }
}

// Реализация товара Б2
class ProductB2 implements AbstractProductB
{
    public function show(): void
    {
        echo 'ProductB2 is Show!'.PHP_EOL;
    }
}

// абстрактный интерфейс фабрики
interface AbstractFactory
{
    // создание
    public function CreateProductA(): AbstractProductA;

    // создание
    public function CreateProductB(): AbstractProductB;
}

// Фабрика 1, реализует товар A1 и товар B1,
class ConcreteFactory1 implements AbstractFactory
{
    public function CreateProductA(): AbstractProductA
    {
        return new ProductA1();
    }

    public function CreateProductB(): AbstractProductB
    {
        return new ProductB1();
    }
}

// Фабрика 2, реализует товар A2 и товар B2,
class ConcreteFactory2 implements AbstractFactory
{
    public function CreateProductA(): AbstractProductA
    {
        return new ProductA2();
    }

    public function CreateProductB(): AbstractProductB
    {
        return new ProductB2();
    }
}


$factory1 = new ConcreteFactory1();
$factory1ProductA = $factory1->CreateProductA();
$factory1ProductB = $factory1->CreateProductB();
$factory1ProductA->show();
$factory1ProductB->show();


$factory2 = new ConcreteFactory2();
$factory2ProductA = $factory2->CreateProductA();
$factory2ProductB = $factory2->CreateProductB();
$factory2ProductA->show();
$factory2ProductB->show();

```

>



![Схема классов рассылки СМС](https://raw.githubusercontent.com/blaywille1/dp/master/03.abstract-factory/img/abstract-factory-message.jpg)

```php

interface Message
{
    public function send(string $msg);
}

interface Push
{
    public function send(string $msg);
}

interface MessageFactory
{
    public function createMessage();

    public function createPush();
}

class AliYunMessage implements Message
{
    public function send(string $msg)
    {
        // вызов интерфейса, отправку текстовых сообщений
        // xxxxx
        return 'Обмен сообщениями в облаке Ali (ранее Ali Fish) отправлен успешно!
         Содержание сообщения: '.$msg;
    }
}

class BaiduYunMessage implements Message
{
    public function send(string $msg)
    {
        // вызов интерфейса, отправку текстовых сообщений
        // вызов интерфейса, отправку текстовых сообщений // XXXXX
        return 'Текстовые сообщения Baidu SMS успешно отправлены!
                    Содержание сообщения: '.$msg;
    }
}

class JiguangMessage implements Message
{
    public function send(string $msg)
    {
        // вызов интерфейса, отправку текстовых сообщений // XXXXX
        return 'Aurora SMS успешно отправлено! 
                Содержание сообщения: '.$msg;
    }
}

class AliYunPush implements Push
{
    public function send(string $msg)
    {
        // call interface, клиент отправляет push // XXXXX
        return 'Али облако Android и iOS push отправлено успешно!
          Отправить содержимое: '.$msg;

    }
}

class BaiduYunPush implements Push
{
    public function send(string $msg)
    {
        // call interface, клиент отправляет push // XXXXX
        return 'Baidu Android & iOS cloud push успешно отправлен! 
         Отправить содержимое: '.$msg;

    }
}

class JiguangPush implements Push
{
    public function send(string $msg)
    {
        // call interface, клиент отправляет push // XXXXX
        return 'Aurora push успешно отправлен! 
         Отправить содержимое: '.$msg;

    }
}

class AliYunFactory implements MessageFactory
{
    public function createMessage()
    {
        return new AliYunMessage();
    }

    public function createPush()
    {
        return new AliYunPush();
    }
}

class BaiduYunFactory implements MessageFactory
{
    public function createMessage()
    {
        return new BaiduYunMessage();
    }

    public function createPush()
    {
        return new BaiduYunPush();
    }
}

class JiguangFactory implements MessageFactory
{
    public function createMessage()
    {
        return new JiguangMessage();
    }

    public function createPush()
    {
        return new JiguangPush();
    }
}


$factory = new AliYunFactory();
// $factory = new BaiduYunFactory();
// $factory = new JiguangFactory();
$message = $factory->createMessage();
$push = $factory->createPush();
echo $message->send('Вы давно не входили в систему, 
                не забудьте вернуться!');
echo $push->send('У вас есть новый прибыл красный конверт,
                проверьте его!');

```

> Для монтажа вам понадобятся разные специалисты: деревянной двери нужен плотник, стальной — сварщик, пластиковой — спец по ПВХ-профилям.

```php
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

```





