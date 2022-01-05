<?php

// Цепочка словарных фильтров
abstract class FilterChain
{
    protected $next;

    public function setNext($next)
    {
        $this->next = $next;
    }

    abstract public function filter($message);
}

// Нет словарного запаса
class FilterStrict extends FilterChain
{
    public function filter($message)
    {
        foreach (['Gun X', 'Bullet X', 'Poison X'] as $v) {
            if (strpos($message, $v) !== false) {
                throw new \Exception('Информация содержит секретные слова
！');
            }
        }
        if ($this->next) {
            return $this->next->filter($message);
        } else {
            return $message;
        }
    }
}

// Предупреждающие слова
class FilterWarning extends FilterChain
{
    public function filter($message)
    {
        $message = str_replace([
            '«Борьба»',
            '«увеличение груди»',
            '«уклонение от уплаты налогов»',
        ], '*', $message);
        if ($this->next) {
            return $this->next->filter($message);
        } else {
            return $message;
        }
    }
}

// Номер мобильного телефона плюс звезда
class FilterMobile extends FilterChain
{
    public function filter($message)
    {
        $message = preg_replace("/(1[3|5|7|8]\d)\d{4}(\d{4})/i", "$1****$2",
            $message);
        if ($this->next) {
            return $this->next->filter($message);
        } else {
            return $message;
        }
    }
}

$f1 = new FilterStrict();
$f2 = new FilterWarning();
$f3 = new FilterMobile();

$f1->setNext($f2);
$f2->setNext($f3);

$m1 = "Теперь приступим к тестированию цепочки 1: 
        предложение не содержит чувствительных слов, 
        вам нужно заменить слово борьба,
";
echo $f1->filter($m1);
echo PHP_EOL;


$m2 = "Теперь приступим к тестированию цепочки 2: 
            это предложение не перейдет в конец, 
            потому что оно содержит яд X,
";
echo $f1->filter($m2);
echo PHP_EOL;
