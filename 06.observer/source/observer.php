<?php

interface Observer
{
    public function update(Subject $subject): void;
}

//Об абстрактном интерфейсе наблюдателя нечего сказать, просто
// позвольте вам реализовать конкретное обновление.
class ConcreteObserver implements Observer
{
    private $observerState = '';

    function update(Subject $subject): void
    {
        $this->observerState = $subject->getState();
        echo 'Выполните операцию наблюдателя! Текущее состояние：'
            .$this->observerState;
    }
}

//Конкретный наблюдатель реализует метод update (), в котором мы получаем класс Subject,
// чтобы можно было получить статус
class Subject
{
    protected $stateNow = '';
    private $observers = [];

    public function attach(Observer $observer): void
    {
        array_push($this->observers, $observer);
    }

    public function detach(Observer $observer): void
    {
        $position = 0;
        foreach ($this->observers as $ob) {
            if ($ob == $observer) {
                array_splice($this->observers, ($position), 1);
            }
            ++$position;
        }
    }

    public function notify(): void
    {
        foreach ($this->observers as $ob) {
            $ob->update($this);
        }
    }
}

// Родительский класс Subject поддерживает массив наблюдателей,
// а затем есть методы для добавления, удаления и цикла по массиву.
// Цель состоит в том, чтобы удобно управлять всеми наблюдателями.

class ConcreteSubject extends Subject
{
    public function setState($state)
    {
        $this->stateNow = $state;
        $this->notify();
    }

    public function getState()
    {
        return $this->stateNow;
    }
}

$observer = new ConcreteObserver();
$observer2 = new ConcreteObserver();
$subject = new ConcreteSubject();
$subject->attach($observer);

// $subject->setState('Ха-ха-ха-ха');
// $subject->detach($observer);
// $subject->setState('Хахахаха 222');

$subject->attach($observer2);
$subject->setState('Ха-ха-ха-ха');

//Класс реализации Subject только обновляет состояние.
//При изменении состояния вызывается метод обхода наблюдателя
// для выполнения операции update () для всех наблюдений.

