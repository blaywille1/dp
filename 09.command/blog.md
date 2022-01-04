Командный режим, также известный как режим действий или бизнес-режим, во многих учебниках в качестве примера будут
использоваться рестораны.
> Как клиенты, мы являемся отправителем заказа, официант - получателем заказа, меню - фактическим заказом, а повар - исполнителем заказа.

Итак, что решает эта модель? Если вы хотите изменить меню, вам просто нужно поговорить с официантом, и он передаст его
повару, то есть мы реализовали разделение клиентов и поваров. То есть разделение вызывающего и реализующего. Конечно,
многие шаблоны проектирования могут это сделать, но то, что может сделать командный режим, - это позволить получателю
команд реализовывать несколько команд (заказы официантам, принимать напитки, подавать блюда) или передавать команду
нескольким разработчикам (приготовление горячего блюда, повар холодных блюд, шеф-повар основных продуктов питания).
Здесь действительно вступает в игру командный режим!!

### например

- Вы пришли в ресторан. Вы (Client) просите официанта (Invoker) принести блюда (Command). Официант перенаправляет запрос
  шеф-повару (Receiver), который знает, что и как готовить.
- Другой пример: вы (Client) включаете (Command) телевизор (Receiver) с помощью пульта (Invoker).

##  

***

- инкапсулируйте запрос как объект, чтобы вы могли параметризовать клиентов различными запросами; ставить запросы в
  очередь или записывать журналы запросов, а также поддерживать отменяемые операции.
- Шаблон «Команда» позволяет инкапсулировать действия в объекты. Ключевая идея — предоставить средства отделения клиента
  от получателя.

***

>

![Командный режим](https://raw.githubusercontent.com/blaywille1/dp/master/09.command/img/command.jpg)

```php
<?php

/*
Прежде всего, мы определяем получателя команды или, что более уместно,
 инициатора команды.
Английское определение слова на диаграмме классов - «invoker».
То есть он инициирует и управляет командами.
*/
class Invoker
{
    public $command;

    public function __construct($command)
    {
        $this->command = $command;
    }

    public function exec()
    {
        $this->command->execute();
    }
}
/*
Далее идет команда, которая является нашим «меню».
Цель этой команды - определить, кто настоящий исполнитель.
*/
abstract class Command
{
    protected $receiver;

    public function __construct(Receiver $receiver)
    {
        $this->receiver = $receiver;
    }

    abstract public function execute();
}

class ConcreteCommand extends Command
{
    public function execute()
    {
        $this->receiver->action();
    }
}

class Receiver
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function action()
    {
        echo $this->name.'Команда выполнена！', PHP_EOL;
    }
}

// Готов к выступлению
$receiverA = new Receiver('A');

// Подготовить заказ
$command = new ConcreteCommand($receiverA);

// Запрашивающий
$invoker = new Invoker($command);
$invoker->exec();

/*
Для звонка клиента мы должны связаться с исполнителем, 
то есть выбрать ресторан с хорошими поварами (Receiver), 
затем подготовить команду, которая является меню (Command), и, наконец, 
передать ее официанту (Invoker).


*/
```

Фактически, пример этого ресторана очень нагляден, и это прекрасный анализ командного режима.
> Как насчет того, чтобы сделать несколько заказов или дать несколько поваров? Не волнуйтесь, следующий код поможет нам решить эту проблему.



**
完整代码：[https://github.com/blaywille1/dp/blob/master/09.command/source/command.php](https://github.com/blaywille1/dp/blob/master/09.command/source/command.php)**

```php
<?php

class Invoker
{
    private $command = [];

    public function setCommand(Command $command)
    {
        $this->command[] = $command;
    }

    public function exec()
    {
        if (count($this->command) > 0) {
            foreach ($this->command as $command) {
                $command->execute();
            }
        }
    }

    public function undo()
    {
        if (count($this->command) > 0) {
            foreach ($this->command as $command) {
                $command->undo();
            }
        }
    }
}

abstract class Command
{
    protected $receiver;
    protected $state;
    protected $name;

    public function __construct(Receiver $receiver, $name)
    {
        $this->receiver = $receiver;
        $this->name = $name;
    }

    abstract public function execute();
}

class ConcreteCommand extends Command
{
    public function execute()
    {
        if ( ! $this->state || $this->state == 2) {
            $this->receiver->action();
            $this->state = 1;
        } else {
            echo $this->name
                .'Команда выполняется и не может быть выполнена снова!', PHP_EOL;
        }

    }

    public function undo()
    {
        if ($this->state == 1) {
            $this->receiver->undo();
            $this->state = 2;
        } else {
            echo $this->name
                .'Команда не была выполнена и не может быть отменена!', PHP_EOL;
        }
    }
}

class Receiver
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function action()
    {
        echo $this->name.'Команда выполнена！', PHP_EOL;
    }

    public function undo()
    {
        echo $this->name.'Заказ отозван！', PHP_EOL;
    }
}

// Готов к выступлению
$receiverA = new Receiver('A');
$receiverB = new Receiver('B');
$receiverC = new Receiver('C');

// Подготовить заказ
$commandOne = new ConcreteCommand($receiverA, 'A');
$commandTwo = new ConcreteCommand($receiverA, 'B');
$commandThree = new ConcreteCommand($receiverA, 'C');

// Запрашивающий
$invoker = new Invoker();
$invoker->setCommand($commandOne);
$invoker->setCommand($commandTwo);
$invoker->setCommand($commandThree);
$invoker->exec();
$invoker->undo();

// Добавляем одного исполнителя, выполняем только одну команду
$invokerA = new Invoker();
$invokerA->setCommand($commandOne);
$invokerA->exec();

// Команда A была выполнена, снова выполняем все исполнители команд, оценка состояния команды A не может вступить в силу
$invoker->exec();



```

-На этот раз мы решили проблему нескольких заказов и нескольких поваров одновременно, а также решили проблему отмены,
если был размещен неправильный заказ. -Можно видеть, что командный режим отделяет объект, вызывающий операцию, от
объекта, который знает, как реализовать операцию. -Реализация этой мульти-команды и мультиисполнителя чем-то напоминает
реализацию комбинированного режима. -В этом случае добавление нового заказа не повлияет ни на исполнителя, ни на
заказчика. Когда новому клиенту нужен новый заказ, нужно добавить только заказ и инициатор запроса. Даже если есть
необходимость в модификации, изменяется только запрашивающая сторона. -В механизме планирования событий фреймворка
Laravel, помимо режима наблюдателя, также очевидно, что можно увидеть тень командного режима.

**
完整代码：[https://github.com/blaywille1/dp/blob/master/09.command/source/command-up.php](https://github.com/blaywille1/dp/blob/master/09.command/source/command-up.php)**

## пример

Функция SMS вернулась.Мы обнаружили, что в дополнение к заводскому режиму, командный режим кажется хорошим способом
реализовать его. Здесь мы по-прежнему используем те немногие интерфейсы SMS и push.Нечего говорить, давайте
воспользуемся командным режимом для реализации другого. Конечно, заинтересованные друзья могут и дальше реализовывать
нашу функцию вывода SMS.Подумайте, как достигается отмена указанной выше команды.

>

![短信发送命令模式版](https://raw.githubusercontent.com/blaywille1/dp/master/09.command/img/command-message.jpg)

**
完整源码：[https://github.com/blaywille1/dp/blob/master/09.command/source/command-message.php](https://github.com/blaywille1/dp/blob/master/09.command/source/command-message.php)**

```php
<?php

class SendMsg
{
    private $command = [];

    public function setCommand(Command $command)
    {
        $this->command[] = $command;
    }

    public function send($msg)
    {
        foreach ($this->command as $command) {
            $command->execute($msg);
        }
    }
}

abstract class Command
{
    protected $receiver = [];

    public function setReceiver($receiver)
    {
        $this->receiver[] = $receiver;
    }

    abstract public function execute($msg);
}

class SendAliYun extends Command
{
    public function execute($msg)
    {
        foreach ($this->receiver as $receiver) {
            $receiver->action($msg);
        }
    }
}

class SendJiGuang extends Command
{
    public function execute($msg)
    {
        foreach ($this->receiver as $receiver) {
            $receiver->action($msg);
        }
    }
}

class SendAliYunMsg
{
    public function action($msg)
    {
        echo '[X Cloud SMS] Отправить:'.$msg, PHP_EOL;
    }
}

class SendAliYunPush
{
    public function action($msg)
    {
        echo '[A X Cloud Push] Отправить:'.$msg, PHP_EOL;
    }
}

class SendJiGuangMsg
{
    public function action($msg)
    {
        echo '【Extreme X SMS】 Отправить:'.$msg, PHP_EOL;
    }
}

class SendJiGuangPush
{
    public function action($msg)
    {
        echo '【Extreme X Push】 Отправить:'.$msg, PHP_EOL;
    }
}

$aliMsg = new SendAliYunMsg();
$aliPush = new SendAliYunPush();
$jgMsg = new SendJiGuangMsg();
$jgPush = new SendJiGuangPush();

$sendAliYun = new SendAliYun();
$sendAliYun->setReceiver($aliMsg);
$sendAliYun->setReceiver($aliPush);

$sendJiGuang = new SendJiGuang();
$sendAliYun->setReceiver($jgMsg);
$sendAliYun->setReceiver($jgPush);

$sendMsg = new SendMsg();
$sendMsg->setCommand($sendAliYun);
$sendMsg->setCommand($sendJiGuang);

$sendMsg->send('На этот раз большое событие, приходите и записывайтесь!');

```

> 说明

-В этом примере это все еще режим нескольких команд и нескольких исполнителей. -Этот пример можно сравнить с абстрактной
фабрикой. Та же функция реализована с использованием разных шаблонов проектирования, но следует отметить, что
абстрактная фабрика больше предназначена для создания и возврата объектов, а командный режим - это выбор поведения. -Мы
видим, что командный режим очень подходит для формирования очереди команд, и несколько команд могут выполняться одна за
другой. -Это позволяет принимающей стороне решить, отклонять ли запрос, а получатель, как исполнитель, имеет больше
права голоса.

## ---

```php
<?php

//Сначала сделаем получателя, содержащего реализации
// каждого действия, которое может быть выполнено.


// Receiver
interface Command
{
    public function execute();

    public function undo();

    public function redo();
}

//Теперь сделаем интерфейс, который будет реализовывать каждая команда.
// Также сделаем набор команд.

class Bulb
{
    public function turnOn()
    {
        echo "Bulb has been lit";
    }

    public function turnOff()
    {
        echo "Darkness!";
    }
}

// Command

class TurnOn implements Command
{
    protected $bulb;

    public function __construct(Bulb $bulb)
    {
        $this->bulb = $bulb;
    }

    public function undo()
    {
        $this->bulb->turnOff();
    }

    public function redo()
    {
        $this->execute();
    }

    public function execute()
    {
        $this->bulb->turnOn();
    }
}

class TurnOff implements Command
{
    protected $bulb;

    public function __construct(Bulb $bulb)
    {
        $this->bulb = $bulb;
    }

    public function undo()
    {
        $this->bulb->turnOn();
    }

    public function redo()
    {
        $this->execute();
    }

    public function execute()
    {
        $this->bulb->turnOff();
    }
}

//Теперь сделаем вызывающего Invoker, с которым будет взаимодействовать
// клиент для обработки команд.


// Invoker
class RemoteControl
{
    public function submit(Command $command)
    {
        $command->execute();
    }
}

//Посмотрим, как всё это может использовать клиент:


$bulb = new Bulb();

$turnOn = new TurnOn($bulb);
$turnOff = new TurnOff($bulb);

$remote = new RemoteControl();
$remote->submit($turnOn); // Лампочка зажглась!
$remote->submit($turnOff); // Темнота!

//Шаблон «Команда» можно использовать и для реализации системы на основе
// транзакций. То есть системы, в которой вы сохраняете историю команд
// по мере их выполнения. Если последняя команда выполнена успешно,
// то всё хорошо. В противном случае система итерирует по истории
// и делает undo для всех выполненных команд.
```
