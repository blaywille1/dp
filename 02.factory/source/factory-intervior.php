<?php

//Сначала создадим интерфейс сотрудника, проводящего собеседование,
// и некоторые реализации для него.


interface Interviewer
{
    public function askQuestions();
}

class Developer implements Interviewer
{
    public function askQuestions()
    {
        echo 'Asking about design patterns!';
    }
}

class CommunityExecutive implements Interviewer
{
    public function askQuestions()
    {
        echo 'Asking about community building';
    }
}

//Теперь создадим кадровичку HiringManager.


abstract class HiringManager
{

    // Фабричный метод
    abstract public function makeInterviewer(): Interviewer;

    public function takeInterview()
    {
        $interviewer = $this->makeInterviewer();
        $interviewer->askQuestions();
    }
}

//Любой дочерний класс может расширять его и предоставлять нужного
// собеседующего:


class DevelopmentManager extends HiringManager
{
    public function makeInterviewer(): Interviewer
    {
        return new Developer();
    }
}

class MarketingManager extends HiringManager
{
    public function makeInterviewer(): Interviewer
    {
        return new CommunityExecutive();
    }
}

//Использование:


$devManager = new DevelopmentManager();
$devManager->takeInterview(); // Output: Спрашивает о шаблонах проектирования.

$marketingManager = new MarketingManager();
$marketingManager->takeInterview(); // Output: Спрашивает о создании сообщества.
/*
Когда использовать?

    Этот шаблон полезен для каких-то общих обработок в классе,
но требуемые подклассы динамически определяются в ходе выполнения (runtime).
 То есть когда клиент не знает, какой именно подкласс может ему понадобиться.


*/
