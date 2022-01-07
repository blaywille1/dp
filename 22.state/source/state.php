<?php

class Context
{
    private $state;

    public function SetState(State $state): void
    {
        $this->state = $state;
    }

    public function Request(): void
    {
        $this->state = $this->state->Handle();
    }
}

// Класс контекста, который также можно рассматривать как целевой класс,
// имеет внутри себя объект состояния. При вызове Request() вызовите метод
// Handle() класса состояния. Цель состоит в том, чтобы изменения текущего
// состояния класса контекста управлялись классом внешнего состояния.

interface State
{
    public function Handle(): State;
}

class ConcreteStateA implements State
{
    public function Handle(): State
    {
        echo 'В настоящее время в состоянии А
', PHP_EOL;

        return new ConcreteStateB();
    }
}

class ConcreteStateB implements State
{
    public function Handle(): State
    {
        echo 'В настоящее время в состоянии B
', PHP_EOL;

        return new ConcreteStateA();
    }
}

// Абстрактный интерфейс состояния и две конкретные реализации.
// Две конкретные реализации фактически вызывают друг друга.
// В результате каждый раз, когда класс контекста вызывает метод Request(),
// класс внутреннего состояния становится другим состоянием.
// Как переключатель, который включает и выключает туда-сюда.

$c = new Context();
$stateA = new ConcreteStateA();
$c->SetState($stateA);
$c->Request();
$c->Request();
$c->Request();
$c->Request();
