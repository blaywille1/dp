# visitor посетитель

Посетители, например, мы посещаем чужой дом, или кто-то приходит к нам домой, чтобы навестить нас. Каждый из нас подобен
сущности, и каждый посетитель приветствует нас один за другим. Ведь наша китайская нация – это нация, уделяющая большое
внимание этикету и гостеприимству. Посетитель — самый сложный шаблон среди 23 шаблонов проектирования GoF, а также
последний шаблон, в котором размещены различные учебники по шаблонам проектирования. Независимо от сложности, давайте
взглянем на его определение и реализацию.

> Туристы собрались в Дубай. Сначала им нужен способ попасть туда (виза). После прибытия они будут посещать любую часть города, не спрашивая разрешения, ходить где вздумается. Просто скажите им о каком-нибудь месте — и туристы могут там побывать. Шаблон «Посетитель» помогает добавлять места для посещения.

## AbCD类图及解释

***

- представляет операцию, которая воздействует на элементы в структуре объекта. Это позволяет вам определять новые
  операции, которые воздействуют на элементы без изменения их классов.
- Шаблон «Посетитель» позволяет добавлять будущие операции для объектов без их модифицирования.
- Шаблон «Посетитель» — это способ отделения алгоритма от структуры объекта, в которой он оперирует. Результат отделения
  — возможность добавлять новые операции в существующие структуры объектов без их модифицирования. Это один из способов
  соблюдения принципа открытости/закрытости (open/closed principle).

***

> AbCD类图

![访问者模式](https://raw.githubusercontent.com/blaywille1/dp/master/23.visitor/img/visitor.jpg)

```php
<?php

interface Visitor
{
    function VisitConcreteElementA(ConcreteElementA $a);
    function VisitConcreteElementB(ConcreteElementB $b);
}

class ConcreteVisitor1 implements Visitor
{
    public function VisitConcreteElementA(ConcreteElementA $a)
    {
        echo get_class($a) . "лоскутное одеяло
" . get_class($this) . "доступ", PHP_EOL;
    }
    public function VisitConcreteElementB(ConcreteElementB $b)
    {
        echo get_class($b) . "лоскутное одеяло
" . get_class($this) . "доступ", PHP_EOL;
    }
}

class ConcreteVisitor2 implements Visitor
{
    public function VisitConcreteElementA(ConcreteElementA $a)
    {
        echo get_class($a) . "лоскутное одеяло
" . get_class($this) . "доступ", PHP_EOL;
    }
    public function VisitConcreteElementB(ConcreteElementB $b)
    {
        echo get_class($b) . "лоскутное одеяло
" . get_class($this) . "доступ", PHP_EOL;
    }
}

// Абстрактный интерфейс посетителя и две конкретные реализации.
// Это можно расценивать как молодую пару, пришедшую к нам в гости!
interface Element
{
    public function Accept(Visitor $v);
}

class ConcreteElementA implements Element
{
    public function Accept(Visitor $v)
    {
        $v->VisitConcreteElementA($this);
    }
    public function OperationA()
    {

    }
}

class ConcreteElementB implements Element
{
    public function Accept(Visitor $v)
    {
        $v->VisitConcreteElementB($this);
    }
    public function OperationB()
    {

    }
}

// Абстракция и реализация элементов также могут рассматриваться
// как сущности, к которым нужно получить доступ.
// Конечно, это я и моя жена.
class ObjectStructure
{
    private $elements = [];

    public function Attach(Element $element)
    {
        $this->elements[] = $element;
    }

    public function Detach(Element $element)
    {
        $position = 0;
        foreach ($this->elements as $e) {
            if ($e == $element) {
                unset($this->elements[$position]);
                break;
            }
            $position++;
        }
    }

    public function Accept(Visitor $visitor)
    {
        foreach ($this->elements as $e) {
            $e->Accept($visitor);
        }
    }

}

// Это объектная структура, которая содержит сущности элементов
// и выполняет вызовы доступа. Давайте встретимся в гостиной
// и поприветствуем друг друга, это гостиная
$o = new ObjectStructure();
$o->Attach(new ConcreteElementA());
$o->Attach(new ConcreteElementB());

$v1 = new ConcreteVisitor1();
$v2 = new ConcreteVisitor2();

$o->Accept($v1);
$o->Accept($v2);

```

> Звонок клиента, наконец, позволил всем официально встретиться и представить друг друга, чтобы пожать друг другу руки. Приятное завершение одного визита.

- Позвольте посетителю вызвать указанный элемент. Здесь следует отметить, что поведение посетителя, вызывающего элемент,
  как правило, фиксировано и редко меняется. То есть два метода VisitConcreteElementA() и VisitConcreteElementB(). То
  есть класс, определяющий структуру объекта, редко меняется, но часто используется шаблон посетителя, когда необходимо
  определить новые операции над этой структурой.
- Шаблон посетителя подходит, когда вам нужно выполнить много разных и несвязанных операций над объектами в структуре
  объекта, и вы хотите избежать того, чтобы эти операции «загрязняли» класс объекта.
- Шаблон посетитель подходит для ситуаций, когда структура данных не меняется. Итак, это режим, который вы обычно не
  используете, но вы можете использовать его только тогда, когда он вам нужен. GoF: «В большинстве случаев вам не нужен
  шаблон посетителя, но когда он вам нужен, он вам действительно нужен». Потому что очень мало случаев, когда структура
  данных не меняется
- Некоторые преимущества и недостатки шаблона посетителя: простота добавления новых операций; централизация связанных
  операций и разделение несвязанных операций; сложность добавления новых классов ConcreteElement; доступ через иерархию
  классов; накопление состояния; нарушение инкапсуляции.

**
完整代码：[https://github.com/blaywille1/dp/blob/master/23.visitor/source/visitor.php](https://github.com/blaywille1/dp/blob/master/23.visitor/source/visitor.php)**

Последний пример шаблона возвращает нас к отправке сообщения. Точно так же есть несколько поставщиков услуг, и как
посетители, они должны использовать свои собственные интерфейсы отправки SMS и push-уведомлений приложений. В это время
вы можете использовать режим посетителя для работы и реализации всех операций этих посетителей.



> 访问者模式信息发送

![访问者模式信息发送](https://raw.githubusercontent.com/blaywille1/dp/master/23.visitor/img/visitor-msg.jpg)

**
完整源码：[https://github.com/blaywille1/dp/blob/master/23.visitor/source/visitor-msg.php](https://github.com/blaywille1/dp/blob/master/23.visitor/source/visitor-msg.php)**

```php
<?php

//Возьмём зоопарк: у нас есть несколько видов животных,
// и нам нужно послушать издаваемые ими звуки.


// Место посещения
interface Animal
{
    public function accept(AnimalOperation $operation);
}

// Посетитель
interface AnimalOperation
{
    public function visitMonkey(Monkey $monkey);

    public function visitLion(Lion $lion);

    public function visitDolphin(Dolphin $dolphin);
}

//Реализуем животных:


class Monkey implements Animal
{
    public function shout()
    {
        echo 'Ooh oo aa aa!';
    }

    public function accept(AnimalOperation $operation)
    {
        $operation->visitMonkey($this);
    }
}

class Lion implements Animal
{
    public function roar()
    {
        echo 'Roaaar!';
    }

    public function accept(AnimalOperation $operation)
    {
        $operation->visitLion($this);
    }
}

class Dolphin implements Animal
{
    public function speak()
    {
        echo 'Tuut tuttu tuutt!';
    }

    public function accept(AnimalOperation $operation)
    {
        $operation->visitDolphin($this);
    }
}

//Реализуем посетителя:


class Speak implements AnimalOperation
{
    public function visitMonkey(Monkey $monkey)
    {
        $monkey->shout();
    }

    public function visitLion(Lion $lion)
    {
        $lion->roar();
    }

    public function visitDolphin(Dolphin $dolphin)
    {
        $dolphin->speak();
    }
}

//Использование:


$monkey = new Monkey();
$lion = new Lion();
$dolphin = new Dolphin();

$speak = new Speak();

$monkey->accept($speak);    // Уа-уа-уааааа!    
$lion->accept($speak);      // Ррррррррр!
$dolphin->accept($speak);   // Туут тутт туутт!

//Это можно было сделать просто с помощью иерархии наследования,
// но тогда пришлось бы модифицировать животных при каждом добавлении
// к ним новых действий. А здесь менять их не нужно. Например,
// мы можем добавить животным прыжки, просто создав нового посетителя:


class Jump implements AnimalOperation
{
    public function visitMonkey(Monkey $monkey)
    {
        echo 'Jumped 20 feet high! on to the tree!';
    }

    public function visitLion(Lion $lion)
    {
        echo 'Jumped 7 feet! Back on the ground!';
    }

    public function visitDolphin(Dolphin $dolphin)
    {
        echo 'Walked on water a little and disappeared';
    }
}

//Использование:


$jump = new Jump();

$monkey->accept($speak);   // Ooh oo aa aa!
$monkey->accept($jump);    // Jumped 20 feet high! on to the tree!

$lion->accept($speak);     // Roaaar!
$lion->accept($jump);      // Jumped 7 feet! Back on the ground!

$dolphin->accept($speak);  // Tuut tutt tuutt!
$dolphin->accept($jump);   // Walked on water a little and disappeared


```
