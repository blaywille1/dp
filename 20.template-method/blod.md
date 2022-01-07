# Шаблон метода шаблона

Шаблон метода шаблона также является одним из шаблонов, которые мы часто используем непреднамеренно. Этот шаблон
является лучшей интерпретацией наследования. Когда в подклассе есть повторяющиеся действия, они извлекаются и помещаются
в родительский класс для унифицированной обработки.Это самое простое и самое популярное объяснение паттерна шаблонного
метода. Так же, как мы обычно делаем проекты, процесс каждого проекта почти одинаков, включая исследования, разработку,
тестирование, развертывание и другие процессы. И конкретно для каждого проекта реализация этих процессов не будет точно
такой же. Этот процесс, как шаблонный метод, позволяет нам каждый раз развиваться в соответствии с этим процессом.

> Допустим, вы собрались строить дома. Этапы будут такими:

- Подготовка фундамента.
- Возведение стен.
- Настил крыши.
- Настил перекрытий.

> Порядок этапов никогда не меняется. Вы не настелите крышу до возведения стен — и т. д. Но каждый этап модифицируется: стены, например, можно возвести из дерева, кирпича или газобетона.

## AbCD类图及解释

***

- определяет скелет алгоритма в операции, откладывая некоторые шаги на подклассы. TemplateMethod позволяет подклассам
  переопределять определенные шаги алгоритма без изменения его структуры.
- «Шаблонный метод» определяет каркас выполнения определённого алгоритма, но реализацию самих этапов делегирует дочерним
  классам.

***

> AbCD类图

![模板方法模式](https://raw.githubusercontent.com/blaywille1/dp/master/20.template-method/img/%20template-method.jpg)

```php
<?php

abstract class AbstractClass
{
    public function TemplateMethod()
    {
        $this->PrimitiveOperation1();
        $this->PrimitiveOperation2();
    }

    abstract public function PrimitiveOperation1();

    abstract public function PrimitiveOperation2();
}

// Определяем абстрактный класс с шаблонным методом TemplateMethod(),
// в котором мы вызываем метод работы алгоритма. И эти абстрактные
// методы алгоритма реализованы в подклассах.
class ConcreteClassA extends AbstractClass
{
    public function PrimitiveOperation1()
    {
        echo 'Конкретный метод реализации класса A 1
', PHP_EOL;
    }

    public function PrimitiveOperation2()
    {
        echo 'Конкретный метод реализации класса А 2
', PHP_EOL;
    }
}

class ConcreteClassB extends AbstractClass
{
    public function PrimitiveOperation1()
    {
        echo 'Конкретный способ реализации класса B 1
', PHP_EOL;
    }

    public function PrimitiveOperation2()
    {
        echo 'Конкретный метод реализации класса B 2
', PHP_EOL;
    }
}

// Для определенных классов реализации им нужно только реализовать алгоритм,
// определенный родительским классом.
$c = new ConcreteClassA();
$c->TemplateMethod();

$c = new ConcreteClassB();
$c->TemplateMethod();

```

При вызове клиента создается экземпляр подкласса, но вызывается шаблонный метод суперкласса, унаследованный подклассом.
Может быть достигнут единый вызов алгоритма.

- Считается, что шаблон метода шаблона в большей или меньшей степени используется друзьями, которые немного занимались
  объектно-ориентированной разработкой. потому что это очень распространено
- В некоторых фреймворках некоторые функциональные классы часто имеют функцию инициализации, и многие другие внутренние
  функции вызываются в функции инициализации, которая на самом деле является применением шаблона метода шаблона.
- Шаблон метода шаблона упрощает реализацию функций ловушек. Так же, как и многие шаблоны или функции-ловушки,
  подготовленные для вас в системах с открытым исходным кодом. Например, некоторые программы с открытым исходным кодом
  для блогов резервируют некоторые рекламные места или подключают функции в специальных местах, чтобы пользователи могли
  использовать их в своих собственных целях.
- Шаблон метода шаблона подходит для: одновременной реализации инвариантной части алгоритма и предоставления реализации
  переменной части подклассу для реализации; извлечения общего поведения в подклассе и централизации его в родительском
  классе; управления поведением подкласса. ;
- Эта модель воплощает в себе принцип под названием «Голливудский закон», который заключается в том, что «не приходите к
  нам, мы приходим к вам».

*В компании я очень уважаю agile-управление проектами, это, конечно, не говорит о том, насколько плохо традиционное
управление проектами, но agile больше подходит для краткосрочной компании, такой как мы. В Agile мы используем фреймворк
Scurm, который на самом деле является шаблоном. Он определяет четыре встречи, трех человек и три инструмента. В
конкретной реализации каждого проекта мы будем следовать этим правилам, но конкретная реализация не будет одинаковой.
Например, иногда у нас есть итерация в неделю, а иногда итерация в месяц. Иногда нам не нужна ретроспектива, а вместо
этого проводится ретроспектива и обзорная встреча вместе. В любом случае мы будем разрабатывать гибкие проекты на базе
Scurm. Мне, как руководителю, достаточно вызвать базовый процесс Scurm в каждом проекте. Поэтому сила компании
неотделима от обучения каждого.Конечно, полезные вещи нужно изучать, делиться и применять во все времена! !

*

**
完整代码：[https://github.com/blaywille1/dp/blob/master/20.template-method/source/template-method.php](https://github.com/blaywille1/dp/blob/master/20.template-method/source/template-method.php)**

## 实例

Прекратите отправлять текстовые сообщения, на этот раз мы реализуем часть инициализации класса Cache. Так же, как классы
инструментов в некоторых фреймворках, упомянутых выше. Как правило, мы будем использовать Memcached или Redis для
реализации Cache, поэтому мы извлекаем общий класс Cache, а затем позволяем классам реализации Memcached и Redis Cache
наследовать его. В общедоступном классе некоторая работа по инициализации класса реализации выполняется через метод
шаблона, который единообразно вызывается родительским классом, а классу реализации нужно только реализовать конкретное
содержимое каждого шага.



> 缓存类图

![缓存模板方法模式版](https://raw.githubusercontent.com/blaywille1/dp/master/20.template-method/img/%20template-method-cache.jpg)

**
完整源码：[https://github.com/blaywille1/dp/blob/master/20.template-method/source/template-method-cache.php](https://github.com/blaywille1/dp/blob/master/20.template-method/source/template-method-cache.php)**

```php
<?php

abstract class Cache
{
    protected $config;
    protected $conn;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->GetConfig();
        $this->OpenConnection();
        $this->CheckConnection();
    }

    abstract public function GetConfig();

    abstract public function OpenConnection();

    abstract public function CheckConnection();
}

class MemcachedCache extends Cache
{
    public function GetConfig()
    {
        echo 'Получить файл конфигурации Memcached
！', PHP_EOL;
        $this->config = 'memcached';
    }

    public function OpenConnection()
    {
        echo 'Ссылка на memcached
!', PHP_EOL;
        $this->conn = 1;
    }

    public function CheckConnection()
    {
        if ($this->conn) {
            echo 'Memcached успешно подключен
！', PHP_EOL;
        } else {
            echo 'Ошибка подключения Memcached, проверьте элементы конфигурации
！', PHP_EOL;
        }
    }
}

class RedisCache extends Cache
{
    public function GetConfig()
    {
        echo 'Получить файл конфигурации Redis
！', PHP_EOL;
        $this->config = 'redis';
    }

    public function OpenConnection()
    {
        echo 'Ссылка redis
!', PHP_EOL;
        $this->conn = 0;
    }

    public function CheckConnection()
    {
        if ($this->conn) {
            echo 'Redis-соединение успешно
！', PHP_EOL;
        } else {
            echo 'Ошибка подключения Redis, проверьте элементы конфигурации
！', PHP_EOL;
        }
    }
}

$m = new MemcachedCache();

$r = new RedisCache();

```

- Мы реализовали вот такой простой класс кеша. Он очень похож на код во многих фреймворках.
- Подклассам нужно только определить свою собственную реализацию, и пусть родительский класс выполняет остальную часть
  повторяющегося кода.Если родительского класса нет, им всем нужно реализовать метод init() самостоятельно.
- Конечно, когда вам нужно добавить другие классы реализации, вам нужно только наследовать родительский класс Cache и
  завершить свою собственную реализацию.Клиенты могут очень легко столкнуться с этими классами реализации, потому что
  они знают, что им нужно сначала вызвать метод инициализации. Вы можете использовать этот класс, независимо от того,
  какой класс реализации один и тот же.

```php
<?php

//Допустим, у нас есть программный инструмент, позволяющий тестировать,
// проводить контроль качества кода (lint), выполнять сборку,
// генерировать отчёты сборки (отчёты о покрытии кода,
// о качестве кода и т. д.), а также развёртывать приложение
// на тестовом сервере.


//Сначала наш базовый класс определяет каркас алгоритма сборки.


abstract class Builder
{

    // Шаблонный метод
    final public function build()
    {
        $this->test();
        $this->lint();
        $this->assemble();
        $this->deploy();
    }

    abstract public function test();

    abstract public function lint();

    abstract public function assemble();

    abstract public function deploy();
}

//Теперь создаём реализации:


class AndroidBuilder extends Builder
{
    public function test()
    {
        echo 'Running android tests';
    }

    public function lint()
    {
        echo 'Linting the android code';
    }

    public function assemble()
    {
        echo 'Assembling the android build';
    }

    public function deploy()
    {
        echo 'Deploying android build to server';
    }
}

class IosBuilder extends Builder
{
    public function test()
    {
        echo 'Running ios tests';
    }

    public function lint()
    {
        echo 'Linting the ios code';
    }

    public function assemble()
    {
        echo 'Assembling the ios build';
    }

    public function deploy()
    {
        echo 'Deploying ios build to server';
    }
}

//Использование:


$androidBuilder = new AndroidBuilder();
$androidBuilder->build();

// Output:
// Выполнение Android-тестов
// Линтинг Android-кода
// Создание Android-сборки
// Развёртывание Android-сборки на сервере

$iosBuilder = new IosBuilder();
$iosBuilder->build();

// Output:
// Выполнение iOS-тестов
// Линтинг iOS-кода
// Создание iOS-сборки
// Развёртывание iOS-сборки на сервере

```
