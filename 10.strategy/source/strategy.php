<?php

interface Strategy
{
    function AlgorithmInterface();
}

class ConcreteStrategyA implements Strategy
{
    function AlgorithmInterface()
    {
        echo "Алгоритм А";
    }
}

class ConcreteStrategyB implements Strategy
{
    function AlgorithmInterface()
    {
        echo "Алгоритм B";
    }
}

class ConcreteStrategyC implements Strategy
{
    function AlgorithmInterface()
    {
        echo "Алгоритм C";
    }
}

//Определите абстракцию и реализацию алгоритма.

class Context
{
    private $strategy;

    function __construct(Strategy $s)
    {
        $this->strategy = $s;
    }

    function ContextInterface()
    {

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
