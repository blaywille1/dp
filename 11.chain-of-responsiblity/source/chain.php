<?php

abstract class Handler
{
    protected $successor;

    public function setSuccessor($successor)
    {
        $this->successor = $successor;
    }

    abstract public function HandleRequst($request);
}

// Определите абстрактный класс цепочки ответственности
// и используйте $ successor, чтобы сохранить цепочку преемников.

class ConcreteHandler1 extends Handler
{
    public function HandleRequst($request)
    {
        if (is_numeric($request)) {
            return 'Параметр запроса - это число：'.$request;
        } else {
            return $this->successor->HandleRequst($request);
        }
    }
}

class ConcreteHandler2 extends Handler
{
    public function HandleRequst($request)
    {
        if (is_string($request)) {
            return 'Параметр запроса - это строка：'.$request;
        } else {
            return $this->successor->HandleRequst($request);
        }
    }
}

class ConcreteHandler3 extends Handler
{
    public function HandleRequst($request)
    {
        return 'Я не знаю, каковы параметры запроса, угадайте, что?
'.gettype($request);
    }
}

// Конкретная реализация трех цепочек ответственности,
// основная функция состоит в том, чтобы определить тип передаваемых
// данных, если это число, первый класс обрабатывается, если это строка,
// второй тип обрабатывается. Если это другие типы, третья категория
// будет обрабатываться единообразно.

$handle1 = new ConcreteHandler1();
$handle2 = new ConcreteHandler2();
$handle3 = new ConcreteHandler3();

$handle1->setSuccessor($handle2);
$handle2->setSuccessor($handle3);

$requests = [22, 'aaa', 55, 'cc', [1, 2, 3], null, new stdClass];

foreach ($requests as $request) {
    echo $handle1->HandleRequst($request).PHP_EOL;
}
