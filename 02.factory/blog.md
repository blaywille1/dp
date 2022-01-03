_Как упоминалось в прошлый раз, простая фабрика не принадлежит к 23 шаблонам проектирования abcdef. На этот раз это
настоящий парень. Знаменитый шаблон фабричного метода здесь_


> Этот шаблон полезен для каких-то общих обработок в классе, но требуемые подклассы динамически определяются в ходе выполнения (runtime). То есть когда клиент не знает, какой именно подкласс может ему понадобиться.

- По сравнению с простой фабрикой, наиболее важным моментом в шаблоне фабричного метода является откладывание реализации
  до подкласса. Как понять? Мы можем взять простую фабрику из прошлого раза в качестве родительского класса, а затем
  получить кучу подклассов для ее наследования. Метод createProduct () также стал абстрактным методом в родительском
  классе. Затем все подклассы реализуют этот метод, больше не нужно использовать переключатель для оценки, подкласс
  может напрямую возвращать экземпляр объекта.
- Это способ делегирования логики создания объектов (instantiation logic) дочерним классам. _Например, одна кадровичка
  не в силах провести собеседования со всеми кандидатами на все должности. В зависимости от вакансии она может
  делегировать разные этапы собеседований разным сотрудникам._

![Диаграмма классов](https://github.com/blaywille1/dp/raw/master/02.factory/img/factory.jpg)

- Продукт на диаграмме классов - это продукт

- Создатель на диаграмме классов - это создатель

- У родительского класса-создателя есть абстрактный фабричный метод FactoryMethod ().

- Все подклассы создателя должны реализовать этот фабричный метод, чтобы вернуть соответствующий конкретный продукт.

- Родительский класс создателя может иметь метод операции AnOperation (), который напрямую возвращает продукт, и может
  использовать FactoryMethod () для возврата, так что внешнему объекту достаточно равномерно вызывать AnOperation ().

```php
<?php

/*
    Первый - это интерфейсы и классы реализации,
    связанные с товарами, которые похожи на интерфейсы
     простой фабрики:
 * */
// Интерфейс продукта
interface Product{
    function show() : void;
}

/*
Далее идет класс абстракции и реализации создателя:
*/
// Класс реализации товара А
class ConcreteProductA implements Product{
    public function show() : void{
        echo "I'm A.\n";
    }
}

// Класс реализации товара Б
class ConcreteProductB implements Product{
    public function show() : void{
        echo "I'm B.\n";
    }
}

// Создатель абстрактного класса
abstract class Creator{

    // Абстрактный фабричный метод
    abstract protected function FactoryMethod() : Product;

    // метод работы
    public function AnOperation() : Product{
        return $this->FactoryMethod();
    }
}

/*
    Между этой и простой фабрикой есть существенная разница: 
    мы удалили отвратительный переключатель и позволили каждому 
    конкретному классу реализации создавать товарные объекты. 
    Правильно, единичный и закрытый.
    Каждый индивидуальный подкласс создателя связан только 
    с одним продуктом в заводском методе. 
 */
// Создатель реализует класс A
class ConcreteCreatorA extends Creator{
    // Метод реализации
    protected function FactoryMethod() : Product{
        return new ConcreteProductA();
    }
}

// Создатель реализует класс Б
class ConcreteCreatorB extends Creator{
    // метод
    protected function FactoryMethod() : Product{
        return new ConcreteProductB();
    }
}

// Товар А, произведенный фабричным методом А
$factoryA = new ConcreteCreatorA();
$productA = $factoryA->AnOperation();

// Товар Б, произведенный фабричным методом Б
$factoryB = new ConcreteCreatorB();
$productB = $factoryB->AnOperation();

// вызов
$productA->show();
$productB->show();

```

### Пример

> _Аналогичная аналогия с мобильными телефонами: я оптовый торговец (клиент, со стороны бизнеса), продающий мобильные телефоны, и мне нужна партия мобильных телефонов (ProductA), поэтому я иду в Fu X Kang (Factory Creator), чтобы помочь мне произвести их. Я объяснил потребности Foxconn, и Foxconn сказал, что да, пусть мой завод в Хэнъян (ConcreteCreatorA) справится с этим. Нет необходимости идти на основной завод. Ваш небольшой заказ, разбрызгайте воду. Через некоторое время мне понадобилась другая модель мобильного телефона (ProductB), и Foxconn взглянул на нее и попросил Чжэнчжоу Foxconn (ConcreteCreatorB) помочь мне в ее производстве. Во всяком случае, несмотря ни на что, мне всегда давали соответствующий сотовый телефон. И фабрика в Чжэнчжоу не знает, что производила фабрика в Хэнъяне, и сотрудничала ли она со мной, все это знают только я и основная фабрика._



**[Схема классов рассылки СМС
](https://github.com/blaywille1/dp/blob/master/02.factory/source/factory.php)**

![短信发送工厂方法](https://github.com/blaywille1/dp/raw/master/02.factory/img/factory-message.jpg)

> 代码实现

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
        // Вызвать интерфейс и отправить СМС
        // ххххх
        return 'Alibaba  Cloud SMS (ранее Ali Big Fish) успешно отправлено!
         Содержание сообщения: '.$msg;

    }
}

class BaiduYunMessage implements Message
{
    public function send(string $msg)
    {
        // Вызвать интерфейс и отправить СМС
        // ххххх
        return 'Baidu  SMS-сообщение успешно отправлено! Содержание сообщения: '
            .$msg;
    }
}

class JiguangMessage implements Message
{
    public function send(string $msg)
    {
        // Вызвать интерфейс и отправить СМС
        // ххххх
        return 'Сообщения Авроры успешно отправлены! Содержание сообщения: '
            .$msg;
    }
}


abstract class MessageFactory
{
    public function getMessage()
    {
        return $this->factoryMethod();
    }

    abstract protected function factoryMethod();
}

class AliYunFactory extends MessageFactory
{
    protected function factoryMethod()
    {
        return new AliYunMessage();
    }
}

class BaiduYunFactory extends MessageFactory
{
    protected function factoryMethod()
    {
        return new BaiduYunMessage();
    }
}

class JiguangFactory extends MessageFactory
{
    protected function factoryMethod()
    {
        return new JiguangMessage();
    }
}

// Текущий бизнес должен использовать Baidu Cloud
$factory = new BaiduYunFactory();
$message = $factory->getMessage();
echo $message->send('У вас новое короткое сообщение, проверьте его');

```

**[полный код](https://github.com/blaywille1/dp/blob/master/02.factory/source/factory-message.php)**

## Пример

> Это способ делегирования логики создания объектов (instantiation logic) дочерним классам. _Одна кадровичка не в силах провести собеседования со всеми кандидатами на все должности. В зависимости от вакансии она может делегировать разные этапы собеседований разным сотрудникам._

```php
<?php

//Сначала создадим интерфейс сотрудника, проводящего собеседование,
// и некоторые реализации для него.


interface Interviewer
{
    public function askQuestions();
}

class Developer implements Interviewer
{
    public function askQuestions()
    {
        echo 'Asking about design patterns!';
    }
}

class CommunityExecutive implements Interviewer
{
    public function askQuestions()
    {
        echo 'Asking about community building';
    }
}

//Теперь создадим кадровичку HiringManager.


abstract class HiringManager
{

    // Фабричный метод
    abstract public function makeInterviewer(): Interviewer;

    public function takeInterview()
    {
        $interviewer = $this->makeInterviewer();
        $interviewer->askQuestions();
    }
}

//Любой дочерний класс может расширять его и предоставлять нужного
// собеседующего:


class DevelopmentManager extends HiringManager
{
    public function makeInterviewer(): Interviewer
    {
        return new Developer();
    }
}

class MarketingManager extends HiringManager
{
    public function makeInterviewer(): Interviewer
    {
        return new CommunityExecutive();
    }
}

//Использование:


$devManager = new DevelopmentManager();
$devManager->takeInterview(); // Output: Спрашивает о шаблонах проектирования.

$marketingManager = new MarketingManager();
$marketingManager->takeInterview(); // Output: Спрашивает о создании сообщества.
/*
Когда использовать?

    Этот шаблон полезен для каких-то общих обработок в классе, 
но требуемые подклассы динамически определяются в ходе выполнения (runtime).
 То есть когда клиент не знает, какой именно подкласс может ему понадобиться.


*/
```
