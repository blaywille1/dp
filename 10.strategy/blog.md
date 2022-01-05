Режим стратегии, также известный как режим политики, представляет собой режим поведенческого проектирования.




***

- определите серию алгоритмов, инкапсулируйте их один за другим и сделайте их взаимозаменяемыми. Этот режим позволяет
  изменять алгоритм независимо от клиентов, которые его используют.
- Шаблон «Стратегия» позволяет переключаться между алгоритмами или стратегиями в зависимости от ситуации.

> Аналогия


Возьмём пример с пузырьковой сортировкой. Мы её реализовали, но с ростом объёмов данных сортировка стала выполняться
очень медленно. Тогда мы сделали быструю сортировку (Quick sort). Алгоритм работает быстрее на больших объёмах, но на
маленьких он очень медленный. Тогда мы реализовали стратегию, при которой для маленьких объёмов данных используется
пузырьковая сортировка, а для больших — быстрая.



***

> AbCD类图

![策略模式](https://raw.githubusercontent.com/blaywille1/dp/master/10.strategy/img/strategy.jpg)

```php
<?php

interface Strategy{
    function AlgorithmInterface();
}

class ConcreteStrategyA implements Strategy{
    function AlgorithmInterface(){
        echo "Алгоритм А";
    }
}

class ConcreteStrategyB implements Strategy{
    function AlgorithmInterface(){
        echo "Алгоритм B";
    }
}

class ConcreteStrategyC implements Strategy{
    function AlgorithmInterface(){
        echo "Алгоритм C";
    }
}

//Определите абстракцию и реализацию алгоритма.

class Context{
    private $strategy;
    function __construct(Strategy $s){
        $this->strategy = $s;
    }
    function ContextInterface(){

        $this->strategy->AlgorithmInterface();
    }
}

// Определите контекст среды выполнения.
$strategyA = new ConcreteStrategyA();
$context = new Context($strategyA);
$context->ContextInterface();

$strategyB = new ConcreteStrategyB();
$context = new Context($strategyB);
$context->ContextInterface();

$strategyC = new ConcreteStrategyC();
$context = new Context($strategyC);
$context->ContextInterface();

/*
Наконец, соответствующий алгоритм вызывается на стороне клиента по мере
необходимости.

-Это очень простой шаблон дизайна? Вы заметили, что эта модель очень похожа
на простую фабрику, о которой мы говорили ранее?

Так в чем же между ними разница?

Фабричный режим относится к режиму создания. Как следует из названия,
этот режим используется для создания объектов и возвращает новые объекты.
 Какой метод вызова объекта определяется клиентом.
Режим поведения атрибута режима стратегии инкапсулирует метод функции,
 который должен быть вызван через контекст выполнения,
 и клиенту нужно только вызвать метод контекста выполнения.

Здесь мы обнаружим, что клиенту требуется создать экземпляры определенных
классов алгоритмов. Кажется, что это не так просто использовать, как простые фабрики . В этом случае почему бы вам не попытаться объединить фабрики и шаблоны стратегии для реализации шаблона ?

В качестве вопроса я оставляю эту реализацию для всех,
напомню: превратите __construct класса Context в простой фабричный метод
*/

```

> Поскольку это так похоже на простую фабрику, мы также следуем простому фабричному методу: мы являемся производителем мобильных телефонов (клиент), мы хотим найти фабрику (ConcreteStrategy) для производства партии мобильных телефонов через поставщика каналов. (Контекст) на этот завод При размещении заказа на производство мобильного телефона дистрибьютор напрямую связывается с литейным заводом (Стратегия) и напрямую отправляет мне готовый мобильный телефон (ContextInterface ()). Точно так же мне не нужно заботиться об их конкретной реализации. Мне нужно только наблюдать за торговым представителем, который контактирует с нами. Разве это не беспокоит?



**
：[https://github.com/blaywille1/dp/blob/master/10.strategy/source/strategy.php](https://github.com/blaywille1/dp/blob/master/10.strategy/source/strategy.php)**

## Пример

Это по-прежнему функция SMS. Для конкретных требований, пожалуйста, обратитесь к объяснению в простом заводском режиме,
но на этот раз мы используем режим стратегии для достижения этого!


> 短信发送类图

![](https://raw.githubusercontent.com/blaywille1/dp/master/10.strategy/img/strategy-message.jpg)

```php
<?php

interface Message
{
    public function send();
}

class BaiduYunMessage implements Message
{
    function send()
    {
        echo 'Baidu Cloud отправляет информацию！';
    }
}

class AliYunMessage implements Message
{
    public function send()
    {
        echo 'Alibaba Cloud отправляет информацию！';
    }
}

class JiguangMessage implements Message
{
    public function send()
    {
        echo 'Аврора отправляет информацию！';
    }
}

class MessageContext
{
    private $message;

    public function __construct(Message $msg)
    {
        $this->message = $msg;
    }

    public function SendMessage()
    {
        $this->message->send();
    }
}

$bdMsg = new BaiduYunMessage();
$msgCtx = new MessageContext($bdMsg);
$msgCtx->SendMessage();

$alMsg = new AliYunMessage();
$msgCtx = new MessageContext($alMsg);
$msgCtx->SendMessage();

$jgMsg = new JiguangMessage();
$msgCtx = new MessageContext($jgMsg);
$msgCtx->SendMessage();

```

**
：[https://github.com/blaywille1/dp/blob/master/10.strategy/source/strategy-message.php](https://github.com/blaywille1/dp/blob/master/10.strategy/source/strategy-message.php)**

- Обратите внимание на сравнение следующих диаграмм классов, разницы между базовыми и простыми фабричными паттернами
  нет.
- Модель стратегии определяет алгоритмы. С концептуальной точки зрения эти алгоритмы выполняют одну и ту же работу, но
  достигают разных реализаций, но вещи мертвы, люди живы, и то, как вы хотите их использовать, не зависит от всеобщих
  интересов.
- Режим стратегии может оптимизировать модульное тестирование, потому что каждый алгоритм имеет свой собственный класс,
  поэтому его можно тестировать индивидуально через собственный интерфейс.

### пример

> Возьмём пример с пузырьковой сортировкой. Мы её реализовали, но с ростом объёмов данных сортировка стала выполняться очень медленно. Тогда мы сделали быструю сортировку (Quick sort). Алгоритм работает быстрее на больших объёмах, но на маленьких он очень медленный. Тогда мы реализовали стратегию, при которой для маленьких объёмов данных используется пузырьковая сортировка, а для больших — быстрая.

```php
<?php

//Возьмём вышеописанный пример. Сначала сделаем интерфейс стратегии и
// реализации самих стратегий.


interface SortStrategy
{
    public function sort(array $dataset): array;
}

class BubbleSortStrategy implements SortStrategy
{
    public function sort(array $dataset): array
    {
        echo "Sorting using bubble sort";

        // Do sorting
        return $dataset;
    }
}

class QuickSortStrategy implements SortStrategy
{
    public function sort(array $dataset): array
    {
        echo "Sorting using quick sort";

        // Do sorting
        return $dataset;
    }
}

//Теперь реализуем клиента, который будет использовать нашу стратегию.


class Sorter
{
    protected $sorter;

    public function __construct(SortStrategy $sorter)
    {
        $this->sorter = $sorter;
    }

    public function sort(array $dataset): array
    {
        return $this->sorter->sort($dataset);
    }
}

//Использование:


$dataset = [1, 5, 4, 3, 2, 8];

$sorter = new Sorter(new BubbleSortStrategy());
$sorter->sort($dataset); // Output : Пузырьковая сортировка

$sorter = new Sorter(new QuickSortStrategy());
$sorter->sort($dataset); // Output : Быстрая сортировка




```
