<?php

//Текстовый редактор меняет состояние текста,
// который вы печатаете, т. е. если выбрано полужирное
// начертание — то редактор печатает полужирным и т. д.


//Сначала сделаем интерфейс состояний и сами состояния:


interface WritingState
{
    public function write(string $words);
}

class UpperCase implements WritingState
{
    public function write(string $words)
    {
        echo strtoupper($words);
    }
}

class LowerCase implements WritingState
{
    public function write(string $words)
    {
        echo strtolower($words);
    }
}

class Defaults implements WritingState
{
    public function write(string $words)
    {
        echo $words;
    }
}

//Сделаем редактор:


class TextEditor
{
    protected $state;

    public function __construct(WritingState $state)
    {
        $this->state = $state;
    }

    public function setState(WritingState $state)
    {
        $this->state = $state;
    }

    public function type(string $words)
    {
        $this->state->write($words);
    }
}

//Использование:


$editor = new TextEditor(new Defaults());

$editor->type('First line');

$editor->setState(new UpperCase());

$editor->type('Second line');
$editor->type('Third line');

$editor->setState(new LowerCase());

$editor->type('Fourth line');
$editor->type('Fifth line');

// Output:
// First line
// SECOND LINE
// THIRD LINE
// fourth line
// fifth line

