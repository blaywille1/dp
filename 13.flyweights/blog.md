### Легковес / приспособленец

Обычно в заведениях общепита чай заваривают не отдельно для каждого клиента, а сразу в некой крупной ёмкости. Это
позволяет экономить ресурсы: газ/электричество, время и т. д. Шаблон «Приспособленец» как раз посвящён общему
использованию (sharing).


***

- используйте технологию совместного использования для эффективной поддержки большого количества мелкозернистых объектов
- Шаблон применяется для минимизирования использования памяти или вычислительной стоимости за счёт общего использования
  как можно большего количества одинаковых объектов.

***

> AbCD类图

![享元模式](https://raw.githubusercontent.com/blaywille1/dp/master/13.flyweights/img/flyweights.jpg)

```php
<?php

interface Flyweight
{
    public function operation($extrinsicState): void;
}

class ConcreteFlyweight implements Flyweight
{
    private $intrinsicState = 101;

    function operation($extrinsicState): void
    {
        echo 'Общий объект-легковес
'.($extrinsicState + $this->intrinsicState).PHP_EOL;
    }
}

class UnsharedConcreteFlyweight implements Flyweight
{
    private $allState = 1000;

    public function operation($extrinsicState): void
    {
        echo 'Необщий легковесный объект：'.($extrinsicState + $this->allState)
            .PHP_EOL;
    }
}

// Определите общий интерфейс и его реализацию.Обратите внимание,
// что существует две реализации: ConcreteFlyweigh разделяет состояние,
// а UnsharedConcreteFlyweight не разделяет или его состояние
// не требует совместного использования.

class FlyweightFactory
{
    private $flyweights = [];

    public function getFlyweight($key): Flyweight
    {
        if ( ! array_key_exists($key, $this->flyweights)) {
            echo "create", PHP_EOL;
            $this->flyweights[$key] = new ConcreteFlyweight();
        }
        var_dump($this->flyweights);

        return $this->flyweights[$key];
    }
}

// Сохраните те объекты, которые должны быть общими, как фабрику
// для создания требуемых общих объектов, чтобы гарантировать,
// что будут только уникальные объекты с одним и тем же значением ключа,
// сэкономив накладные расходы на создание одного и того же объекта.

$factory = new FlyweightFactory();

$extrinsicState = 100;
$flA = $factory->getFlyweight('a');
$flA->operation(--$extrinsicState);

$flB = $factory->getFlyweight('b');
$flB->operation(--$extrinsicState);

$flC = $factory->getFlyweight('c');
$flC->operation(--$extrinsicState);

$flD = new UnsharedConcreteFlyweight();
$flD->operation(--$extrinsicState);

$c = $factory->getFlyweight('c');


```

```php
<?php

//Сделаем типы чая и чайника.


// Приспособленец — то, что будет закешировано.
// Типы чая здесь — приспособленцы.
class KarakTea
{
}

// Действует как фабрика и экономит чай
class TeaMaker
{
    protected $availableTea = [];

    public function make($preference)
    {
        if (empty($this->availableTea[$preference])) {
            $this->availableTea[$preference] = new KarakTea();
        }

        return $this->availableTea[$preference];
    }
}

//Сделаем забегаловку TeaShop, принимающую и обрабатывающую заказы:


class TeaShop
{
    protected $orders;
    protected $teaMaker;

    public function __construct(TeaMaker $teaMaker)
    {
        $this->teaMaker = $teaMaker;
    }

    public function takeOrder(string $teaType, int $table)
    {
        $this->orders[$table] = $this->teaMaker->make($teaType);
    }

    public function serve()
    {
        foreach ($this->orders as $table => $tea) {
            echo "Serving tea to table# ".$table;
        }
    }
}

//Использование:


$teaMaker = new TeaMaker();
$shop = new TeaShop($teaMaker);

$shop->takeOrder('less sugar', 1);
$shop->takeOrder('more milk', 2);
$shop->takeOrder('without sugar', 5);

$shop->serve();
// Serving tea to table# 1
// Serving tea to table# 2
// Serving tea to table# 5

```

**
完整代码：[https://github.com/blaywille1/dp/blob/master/13.flyweights/source/flyweights.php](https://github.com/blaywille1/dp/blob/master/13.flyweights/source/flyweights.php)**

## 实例

Разумеется, мы по-прежнему пришли отправлять текстовые сообщения. На этот раз текстовые сообщения по-прежнему
отправляются с использованием текстовых сообщений Alibaba Cloud и Jiguang, но на этот раз для этого мы используем режим
«Легковес». Здесь мы сохранили два разных типа «Легковесов». о, пусть они постоянно меняются в своем внутреннем и
внешнем состояниях!



> 短信发送类图

![短信发送享元模式版](https://raw.githubusercontent.com/blaywille1/dp/master/13.flyweights/img/flyweights-message.jpg)

**
完整源码：[https://github.com/blaywille1/dp/blob/master/13.flyweights/source/flyweights-message.php](https://github.com/blaywille1/dp/blob/master/13.flyweights/source/flyweights-message.php)**

```php
<?php

interface Message
{
    public function send(User $user);
}

class AliYunMessage implements Message
{
    private $template;
    public function __construct($template)
    {
        $this->template = $template;
    }
    public function send(User $user)
    {
        echo 'Используйте Alibaba Cloud SMS, чтобы
' . $user->GetName() . 'Отправить：';
        echo $this->template->GetTemplate(), PHP_EOL;
    }
}

class JiGuangMessage implements Message
{
    private $template;
    public function __construct($template)
    {
        $this->template = $template;
    }
    public function send(User $user)
    {
        echo 'Используйте SMS Aurora на
' . $user->GetName() . 'Отправить：';
        echo $this->template->GetTemplate(), PHP_EOL;
    }
}

class MessageFactory
{
    private $messages = [];
    public function GetMessage(Template $template, $type = 'ali')
    {
        $key = md5($template->GetTemplate() . $type);
        if (!key_exists($key, $this->messages)) {
            if ($type == 'ali') {
                $this->messages[$key] = new AliYunMessage($template);
            } else {
                $this->messages[$key] = new JiGuangMessage($template);
            }
        }
        return $this->messages[$key];
    }

    public function GetMessageCount()
    {
        echo count($this->messages);
    }
}

class User
{
    public $name;
    public function GetName()
    {
        return $this->name;
    }
}

class Template
{
    public $template;
    public function GetTemplate()
    {
        return $this->template;
    }
}

// Внутреннее состояние
$t1 = new Template();
$t1->template = 'Шаблон 1, хорошо
！';

$t2 = new Template();
$t2->template = 'Шаблон 2, хорошо
！';

// Внешнее состояние
$u1 = new User();
$u1->name = 'Чжан Сан
';

$u2 = new User();
$u2->name = 'Ли Си
';

$u3 = new User();
$u3->name = 'Ван Ву
';

$u4 = new User();
$u4->name = 'Чжао Лю
';

$u5 = new User();
$u5->name = 'Тиан Ци
';

// Завод Сянюань
$factory = new MessageFactory();

// Отправка через Alibaba Cloud
$m1 = $factory->GetMessage($t1);
$m1->send($u1);

$m2 = $factory->GetMessage($t1);
$m2->send($u2);

echo $factory->GetMessageCount(), PHP_EOL; // 1

$m3 = $factory->GetMessage($t2);
$m3->send($u2);

$m4 = $factory->GetMessage($t2);
$m4->send($u3);

echo $factory->GetMessageCount(), PHP_EOL; // 2

$m5 = $factory->GetMessage($t1);
$m5->send($u4);

$m6 = $factory->GetMessage($t2);
$m6->send($u5);

echo $factory->GetMessageCount(), PHP_EOL; // 2

// Присоединяйтесь к Авроре
$m1 = $factory->GetMessage($t1, 'jg');
$m1->send($u1);

$m2 = $factory->GetMessage($t1);
$m2->send($u2);

echo $factory->GetMessageCount(), PHP_EOL; // 3

$m3 = $factory->GetMessage($t2);
$m3->send($u2);

$m4 = $factory->GetMessage($t2, 'jg');
$m4->send($u3);

echo $factory->GetMessageCount(), PHP_EOL; // 4

$m5 = $factory->GetMessage($t1, 'jg');
$m5->send($u4);

$m6 = $factory->GetMessage($t2, 'jg');
$m6->send($u5);

echo $factory->GetMessageCount(), PHP_EOL; // 4

```

- Кода многовато, но на самом деле существует два типа классов и генерируются четыре типа объектов. Здесь разные объекты
  каждого класса различаются в соответствии с шаблоном.
- Эта комбинация более удобна и сочетается с другими режимами, чтобы оптимизировать фабрику здесь. Что ж, будущее
  безгранично, вы можете думать об этом!
- Легковесный режим подходит для сценариев, в которых имеется большое количество похожих объектов в системе и требуется
  буферный пул. Он может уменьшить использование памяти и повысить эффективность, но усложняет ситуацию и требует
  совместного использования внутреннего и внешнего состояний.
- Главная особенность - наличие уникального идентификатора: когда объект уже существует в памяти, объект возвращается
  напрямую, и создавать его не нужно.


