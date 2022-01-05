...Электроприборы из-за границы или путешествуем за границу по делам, нам часто нужен адаптер питания, потому что
стандарт напряжения в нашей стране составляет 220 вольт, в то время как в других странах есть стандарты на 110 вольт.

> Аналогия


Допустим, у вас на карте памяти есть какие-то картинки. Их нужно перенести на компьютер. Нужен адаптер, совместимый с
входным портом компьютера, в который можно вставить карту памяти. В данном примере адаптер — это картридер. Ещё один
пример: переходник, позволяющий использовать американский блок питания с российской розеткой. Третий пример: переводчик
— это адаптер, соединяющий двух людей, говорящих на разных языках.

##  

***

- преобразовать интерфейс класса в другой интерфейс, который нужен клиенту. Режим адаптера позволяет классам, которые не
  могут работать вместе из-за несовместимых интерфейсов, работать вместе
- Шаблон «Адаптер» позволяет помещать несовместимый объект в обёртку, чтобы он оказался совместимым с другим классом.

***

> Наследование


![适配器方法结构类图-继承式](https://raw.githubusercontent.com/blaywille1/dp/master/05.adapter/img/adapter-1.jpg)

> Комбинация

![适配器方法结构类图-组合式](https://raw.githubusercontent.com/blaywille1/dp/master/05.adapter/img/adapter-2.jpg)

```php
<?php

interface Target
{
    function Request(): void;
}

//Определите контракт интерфейса или это может быть обычный класс
// с методами реализации (мы будем использовать классы в следующих примерах)

class Adapter implements Target
{
    private $adaptee;

    function __construct($adaptee)
    {
        $this->adaptee = $adaptee;
    }

    function Request(): void
    {
        $this->adaptee->SpecificRequest();
    }
}

//Адаптер реализует этот интерфейсный контракт, позволяя реализовать
// метод Request (), но обратите внимание, что на самом деле
// мы вызываем метод в классе Adaptee.

class Adaptee
{
    function SpecificRequest(): void
    {
        echo "I'm China Standard！";
    }
}

// Я клиент
$adaptee = new Adaptee();
$adapter = new Adapter($adaptee);
$adapter->Request();

```

- Существует два типа адаптеров. Как показано на приведенной выше диаграмме классов, комбинация нашей реализации кода
- Режим адаптера на самом деле очень прост для понимания, код действительно имеет только эту точку

> Продолжайте писать сообщения и посмотрите, когда я смогу его скомпилировать ~~~

Когда вы подключаетесь к информационным и платежным интерфейсам, вы часто используете SDK, предоставляемые этими
платформами. SDK, особенно с Composer, удобнее устанавливать.Однако есть еще одна серьезная проблема: хотя функции SDK,
созданных этой группой людей, схожи по функциям, названия сильно отличаются! ! Наша система всегда использовала бизнес
Alibaba Cloud, но на этот раз мы должны увеличить информационные функции Jiguang и Baidu Cloud. Один должен быть
резервным, а другой - использовать разные интерфейсы в зависимости от бизнеса для достижения безопасности или экономии.
Есть ли способ унифицировать их внешние интерфейсы, чтобы при использовании их SDK было очень удобно использовать тот же
интерфейс Alibaba Cloud, к которому все уже привыкли раньше? Конечно, есть. Дайте каждому из них по адаптеру. При
создании экземпляра будет сложно настроить внешнюю фабрику и вернуть другой адаптер. Пока метод реализации в адаптере
такой же, как и в Alibaba Cloud, он будет в порядке!

![短信发送装饰器方法](https://raw.githubusercontent.com/blaywille1/dp/master/05.adapter/img/adapter-message.jpg)

**完整源码：[短信发送适配器方法](https://github.com/blaywille1/dp/blob/master/05.adapter/source/adapter-message.php)**

```php
<?php

class Message
{
    public function send()
    {
        echo "Отправить SMS из облака Alibaba！".PHP_EOL;
    }

    public function push()
    {
        echo "Alibaba Cloud отправляет push！".PHP_EOL;
    }
}

class JiguangSDKAdapter extends Message
{
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function send()
    {
        $this->message->send_out_msg();
    }

    public function push()
    {
        $this->message->push_msg();
    }
}

class JiguangMessage
{
    public function send_out_msg()
    {
        echo "Аврора отправляет смс！".PHP_EOL;
    }

    public function push_msg()
    {
        echo "Аврора отправить толчок！".PHP_EOL;
    }
}

class BaiduYunSDKAdapter extends Message
{
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function send()
    {
        $this->message->transmission_msg();
    }

    public function push()
    {
        $this->message->transmission_push();
    }
}

class BaiduYunMessage
{
    public function transmission_msg()
    {
        echo "Отправить SMS из Baidu Cloud！".PHP_EOL;
    }

    public function transmission_push()
    {
        echo "Облако Baidu push push！".PHP_EOL;
    }
}

$jiguangMessage = new JiguangMessage();
$baiduYunMessage = new BaiduYunMessage();
$message = new Message();

// Исходная старая система отправляет текстовые сообщения,
// используя Alibaba Cloud
$message->send();
$message->push();


// Используйте Аврору для отправки некоторых модулей
$jgAdatper = new JiguangSDKAdapter($jiguangMessage);
$jgAdatper->send();
$jgAdatper->push();

// Используйте Baidu Cloud для отправки некоторых модулей
$bdAatper = new BaiduYunSDKAdapter($baiduYunMessage);
$bdAatper->send();
$bdAatper->push();

```

- Комбинированный адаптер похож на декоратор в том, что он будет поддерживать внешний объект. Декоратор будет
  использовать методы исходного класса для добавления к нему функций, в то время как адаптер редко добавляет функции, а
  напрямую заменяет его.
- В модуле Filesystem в Laravel есть класс FilesystemAdapter. Я не думаю, что здесь есть что сказать. Очевидно, скажите
  всем, что мы использовали режим адаптера. Давайте внимательно его изучим.

```php
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

```
