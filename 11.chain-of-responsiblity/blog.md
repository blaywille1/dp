Шаблон цепочки ответственности относится к шаблону проектирования типа поведения объекта.

> Цепочка ответственности кажется очень сложным шаблоном проектирования, и у него действительно есть зрелые приложения во многих текущих фреймворках или системах. Если вы не понимаете этот шаблон, вы можете быть в растерянности, когда прочитаете или поймете некоторые знания фреймворка. В недоумении.

***
Допустим, для вашего банковского счёта доступны три способа оплаты (A, B и C). Каждый подразумевает разные доступные
суммы денег: A — 100 долларов, B — 300, C — 1000. Приоритетность способов при оплате: А, затем В, затем С. Вы пытаетесь
купить что-то за 210 долларов. На основании «цепочки ответственности» система попытается оплатить способом А. Если денег
хватает — то оплата проходит, а цепочка прерывается. Если денег не хватает — то система переходит к способу В, и т. д.


***

## AbCD类图及解释

***

- дать нескольким объектам возможность обрабатывать запрос, тем самым избегая взаимосвязи между отправителем и
  получателем запроса. Соедините эти объекты в цепочку и передайте запрос по этой цепочке, пока объект не обработает его
- Шаблон «Цепочка ответственности» позволяет создавать цепочки объектов. Запрос входит с одного конца цепочки и движется
  от объекта к объекту, пока не будет найден подходящий обработчик.

***


![责任链模式](https://raw.githubusercontent.com/blaywille1/dp/master/11.chain-of-responsiblity/img/chain.jpg)

```php
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

```

Вызов от клиента по очереди создает три экземпляра цепочки ответственности и указывает участников цепочки. Создайте
параметры запроса, а затем оцените результат по цепочке ответственности.

- Сценарий, в котором очень подходит цепочка ответственности, - это фильтрация параметров запроса слой за слоем, как
  когда мы работаем с офисным программным обеспечением, таким как Dingding. Когда необходимо подать заявку на
  сверхурочную работу или отпуск, поэтапный процесс утверждения является идеальным объяснением этой модели.
- Мы можем перехватить запрос и вернуть его напрямую, или мы можем изменить содержимое запроса и передать его следующему
  классу для обработки, но по крайней мере один класс должен вернуть результат.
- Запрос не всегда может быть обработан, и он может быть возвращен без обработки вообще или передан следующему классу
  обработки для обработки.

**
完整代码：[https://github.com/blaywille1/dp/blob/master/11.chain-of-responsiblity/source/chain.php](https://github.com/blaywille1/dp/blob/master/11.chain-of-responsiblity/source/chain.php)**

## Пример

По-прежнему функция SMS, но на этот раз мы хотим реализовать подфункцию фильтрации содержимого SMS. Всем известно, что у
нас строгие правила в отношении рекламы, многие слова отмечены как запрещенные в Законе о рекламе, а некоторые серьезные
слова могут вызвать ненужные хлопоты. На данный момент нам нужен набор механизмов фильтрации для фильтрации словарного
запаса. Для различных типов словаря мы можем фильтровать по цепочке ответственности.Например, словарный запас, который
является серьезно незаконным, конечно, не может передать эту информацию. Мы можем заменить или добавить звездочки для
некоторых более серьезных слов, но можно обойтись без слов. Таким образом, клиенту не нужно много if..else .., чтобы
делать логические суждения, и использовать цепочку ответственности, чтобы позволить им просматривать и одобрять шаг за
шагом. !

![短信过滤责任链模式版](https://raw.githubusercontent.com/blaywille1/dp/master/11.chain-of-responsiblity/img/chain-filter-message.jpg)

**
完整源码：[https://github.com/blaywille1/dp/blob/master/11.chain-of-responsiblity/source/chain-filter-message.php](https://github.com/blaywille1/dp/blob/master/11.chain-of-responsiblity/source/chain-filter-message.php)**

```php
<?php

//Создадим основной банковский счёт, содержащий логику
// связывания счетов в цепочки, и сами счета.


abstract class Account
{
    protected $successor;
    protected $balance;

    public function setNext(Account $account)
    {
        $this->successor = $account;
    }

    public function pay(float $amountToPay)
    {
        if ($this->canPay($amountToPay)) {
            echo sprintf('Paid %s using %s'.PHP_EOL, $amountToPay,
                get_called_class());
        } elseif ($this->successor) {
            echo sprintf('Cannot pay using %s. Proceeding ..'.PHP_EOL,
                get_called_class());
            $this->successor->pay($amountToPay);
        } else {
            throw new Exception('None of the accounts have enough balance');
        }
    }

    public function canPay($amount): bool
    {
        return $this->balance >= $amount;
    }
}

class Bank extends Account
{
    protected $balance;

    public function __construct(float $balance)
    {
        $this->balance = $balance;
    }
}

class Paypal extends Account
{
    protected $balance;

    public function __construct(float $balance)
    {
        $this->balance = $balance;
    }
}

class Bitcoin extends Account
{
    protected $balance;

    public function __construct(float $balance)
    {
        $this->balance = $balance;
    }
}

//Теперь с помощью определённых выше линков (Bank, Paypal, Bitcoin)
// подготовим цепочку:


// Сделаем такую цепочку
//      $bank->$paypal->$bitcoin
//
// Приоритет у банка
//      Если банк не может оплатить, переходим к Paypal
//      Если Paypal не может, переходим к Bitcoin

$bank = new Bank(100);          // У банка баланс 100
$paypal = new Paypal(200);      // У Paypal баланс 200
$bitcoin = new Bitcoin(300);    // У Bitcoin баланс 300

$bank->setNext($paypal);
$paypal->setNext($bitcoin);

// Начнём с банка
$bank->pay(259);

// Выходной вид
// ==============
// Нельзя оплатить с помощью банка. Обрабатываю...
// Нельзя оплатить с помощью Paypal. Обрабатываю...
// Оплачено 259 с помощью Bitcoin!

```
