#

Простая фабрика, также называемая статической фабрикой, не относится к шаблонам проектирования abcdef

> Простая фабрика просто генерирует экземпляр для клиента без предоставления какой-либо логики экземпляра.

> В объектно ориентированном программировании фабрикой называется объект, создающий другие объекты. Формально фабрика — это функция или метод, возвращающая объекты разных прототипов или классов из вызова какого-то метода, который считается новым.

```php
// Factory
class Factory
{
    public static function createProduct(string $type) : Product
    {
        $product = null;
        switch ($type) {
            case 'A':
                $product = new ProductA();
                break;
            case 'B':
                $product = new ProductB();
                break;
        }
        return $product;
    }
}
```

..ключевой момент - это простой код переключения посередине, и мы исправили его как реализацию интерфейса Product в типе
возвращаемого значения

```php
// Products
interface Product
{
    public function show();
}

class ProductA implements Product
{
    public function show()
    {
        echo 'Show ProductA';
    }
}

class ProductB implements Product
{
    public function show()
    {
        echo 'Show ProductB';
    }
}
```

_Более наглядная аналогия: я оптовый торговец (**Client**, со стороны бизнеса), продающий мобильные телефоны. Мне нужна
партия мобильных телефонов (**Product**), поэтому я прошу Foxconn (**Factory**) помочь мне произвести их.

Я разместил заказ (переменная $ type) на указание модели, затем Foxconn дал мне телефон соответствующей модели, и я
продолжил свою работу.Сотрудничество с Foxconn действительно очень приятно._

```php
// Client
$productA = Factory::createProduct('A');
$productB = Factory::createProduct('B');
$productA->show();
$productB->show();
```

![简单工厂-讲解](https://raw.githubusercontent.com/blaywille1/dp/master/01.simple-factory/%08img/simple-factory.jpg)

### Пример

Сценарий: функциональный модуль отправки SMS. Теперь мы пользуемся услугами SMS трех продавцов, а именно Alibaba Cloud,
Diexin и Jiguang. В разных компаниях могут использоваться разные отправители SMS. Это требование может быть легко
выполнено с помощью простых фабрик.



> Диаграмма классов

![简单工厂-消息发送](https://raw.githubusercontent.com/blaywille1/dp/master/01.simple-factory/%08img/simple-factory-message.jpg)

```php
<?php

interface Message
{
    public function send(string $msg);
}

class AliYunMessage implements Message
{
    public function send(string $msg)
    {
        // вызов интерфейса, отправку текстовых сообщений // XXXXX
        return 'Обмен сообщениями в облаке 
         Ali (ранее Ali Fish) отправлен успешно! 
         Содержание сообщения: '.$msg;

    }
}

class BaiduYunMessage implements Message
{
    public function send(string $msg)
    {
        // вызов интерфейса, отправку текстовых сообщений // XXXXX
        return 'Текстовые сообщения Baidu SMS успешно
          отправлены! Содержание сообщения: '.$msg;

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

class MessageFactory
{
    public static function createFactory($type)
    {
        switch ($type) {
            case 'Ali':
                return new AliYunMessage();
            case 'BD':
                return new BaiduYunMessage();
            case 'JG':
                return new JiguangMessage();
            default:
                return null;
        }
    }
}

// Текущие потребности бизнеса использовать Jiguang 
$message = MessageFactory::createMessage('Али');
echo $message->send(" У вас есть новое короткое сообщение,
пожалуйста , проверьте его");


```

### Пример

Простая фабрика просто генерирует экземпляр для клиента без предоставления какой-либо логики экземпляра.

Допустим, вы строите на стройплощадке дом и вам нужны двери. Будет бардак, если каждый раз, когда вам требуется дверь,
вы станете вооружаться инструментами и делать её на стройплощадке. Вместо этого вы закажете двери на фабрике.

```php
<?php

/*
Для начала нам нужен интерфейс двери и его реализация.
*/

interface Door
{
    public function getWidth(): float;

    public function getHeight(): float;
}

class WoodenDoor implements Door
{
    protected $width;
    protected $height;

    public function __construct(float $width, float $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function getWidth(): float
    {
        return $this->width;
    }

    public function getHeight(): float
    {
        return $this->height;
    }
}

/*
Теперь соорудим фабрику дверей, которая создаёт и возвращает нам двери.
*/

class DoorFactory
{
    public static function makeDoor($width, $height): Door
    {
        return new WoodenDoor($width, $height);
    }
}

//Использование:

$door = DoorFactory::makeDoor(100, 200);
echo 'Width: '.$door->getWidth();
echo 'Height: '.$door->getHeight();

```


