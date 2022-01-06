<?php

class Originator
{
    private $state;

    public function SetMeneto(Memento $m)
    {
        $this->state = $m->GetState();
    }

    public function CreateMemento()
    {
        $m = new Memento();
        $m->SetState($this->state);

        return $m;
    }

    public function SetState($state)
    {
        $this->state = $state;
    }

    public function ShowState()
    {
        echo $this->state, PHP_EOL;
    }
}

// Инициатор также может называться инициатором.
// У него есть внутреннее состояние (состояние), которое может быть
// изменено при разных обстоятельствах. Когда происходит событие,
// необходимо восстановить исходное состояние. Здесь у нас есть
// CreateMemento () для создания заметки (архива) и SetMeneto ()
// для восстановления состояния (чтения файла).

class Memento
{
    private $state;

    public function GetState()
    {
        return $this->state;
    }

    public function SetState($state)
    {
        $this->state = $state;
    }
}

// Заметки, очень простые, используются для записи статуса.
// Сохранение этого состояния в форме объекта позволяет создателю
// легко создавать множество архивов для записи различных состояний.

class Caretaker
{
    private $memento;

    public function GetMemento()
    {
        return $this->memento;
    }

    public function SetMemento($memento)
    {
        $this->memento = $memento;
    }
}

// Ответственное лицо, также называемое классом менеджеров,
// сохраняет записку и при необходимости извлекает ее отсюда.
// Он отвечает только за сохранение и не может изменять заметку.
// В сложных приложениях это можно сделать списком, так же как
// несколько архивных записей могут выборочно отображаться в игре,
// чтобы игроки могли выбирать из них.

$o = new Originator();
$o->SetState('Состояние 1
');
$o->ShowState();

// Сохранить состояние
$c = new Caretaker();
$c->SetMemento($o->CreateMemento());

$o->SetState('Состояние 2');
$o->ShowState();

// Восстановленное состояние
$o->SetMeneto($c->GetMemento());
$o->ShowState();
