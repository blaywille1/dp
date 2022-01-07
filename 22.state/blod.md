# состояние / статус / state

Паттерн состояния буквально не очень хорошо понят. Что здесь означает статус? сохранить состояние? Это не режим заметок.
На самом деле состояние здесь — это состояние класса.Изменив определенное состояние класса, класс чувствует, что класс
был изменен. Это немного сложно сказать, поэтому я сначала прочитаю концепции.

> Допустим, в графическом редакторе вы выбрали инструмент «Кисть». Она меняет своё поведение в зависимости от настройки цвета: т. е. рисует линию выбранного цвета.

## AbCD类图及解释

***

- Шаблон позволяет менять поведение класса при изменении состояния.

***

> AbCD类图

![状态模式](https://raw.githubusercontent.com/blaywille1/dp/master/22.state/img/state.jpg)

```php
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


```

> Реализация клиента, создание экземпляра объекта контекста и установка начального состояния, а затем переключение состояния переключателя путем непрерывного вызова объекта Request().

- Видишь дверной проем? Здесь изменение состояния инкапсулируется во внешний класс реализации, а не в контекст или
  целевой класс для переключения состояния.
- Так в чем же смысл шаблона состояния? Пример этой диаграммы классов по умолчанию слишком прост. Фактически, реальная
  цель режима состояния состоит в том, чтобы решить сложную проблему вложенности if. Поместите сложные условия
  вложенности if во внешние классы состояния один за другим, чтобы судить. В следующем примеры мы увидим
- Применимо к: поведение объекта зависит от его состояния, и он должен менять свое поведение в соответствии с состоянием
  во время выполнения; операция содержит большое количество многоветвевых условных операторов, и эти ветви зависят от
  состояния объекта;
- Характеристики шаблона состояния: он локализует поведение, связанное с конкретным состоянием, делает переходы между
  состояниями явными, объекты состояния могут быть общими, объекты состояния могут использоваться совместно.
- Общие для системы заказов, системы членства, системы OA, то есть в процессе будут происходить различные изменения
  состояния, вы можете использовать режим состояния для выполнения общего дизайна и архитектуры.

**
完整代码：[https://github.com/blaywille1/dp/blob/master/22.state/source/state.php](https://github.com/blaywille1/dp/blob/master/22.state/source/state.php)**

## 实例

_
Мы настроили нашу собственную систему торговых центров в нашей системе мобильной связи, и вы можете легко разместить
заказ на покупку нашей продукции на своем мобильном телефоне. Заказ (контекст) будет иметь несколько состояний (
состояние), таких как неоплаченный, оплаченный, заказ выполнен, заказ возвращен и многие другие состояния. Мы помещаем
эти состояния в соответствующий класс состояний для реализации, и разные классы состояний будут вызывать следующее
действие состояния, например, ожидание получения товара после оплаты и ожидание заполнения покупателем логистического
списка после возврата средств. Подождите, таким образом, в нашем торговом центре гибко используется статусный режим! !

_

> 会员折扣图

![会员折扣状态模式版](https://raw.githubusercontent.com/blaywille1/dp/master/22.state/img/state-member.jpg)

**
完整源码：[https://github.com/blaywille1/dp/blob/master/22.state/source/state-member.php](https://github.com/blaywille1/dp/blob/master/22.state/source/state-member.php)**

```php
<?php

interface State
{
    public function discount($member);
}

class Member
{
    private $state;
    private $score;

    public function SetState($state)
    {
        $this->state = $state;
    }

    public function GetScore()
    {
        return $this->score;
    }

    public function SetScore($score)
    {
        $this->score = $score;
    }

    public function discount()
    {
        return $this->state->discount($this);
    }
}

class PlatinumMemeberState implements State
{
    public function discount($member)
    {
        if ($member->GetScore() >= 1000) {
            return 0.80;
        } else {
            $member->SetState(new GoldMemberState());

            return $member->discount();
        }
    }
}

class GoldMemberState implements State
{
    public function discount($member)
    {
        if ($member->GetScore() >= 800) {
            return 0.85;
        } else {
            $member->SetState(new SilverMemberState());

            return $member->discount();
        }
    }
}

class SilverMemberState implements State
{
    public function discount($member)
    {
        if ($member->GetScore() >= 500) {
            return 0.90;
        } else {
            $member->SetState(new GeneralMemberState());

            return $member->discount();
        }
    }
}

class GeneralMemberState implements State
{
    public function discount($member)
    {
        return 0.95;
    }
}

$m = new Member();
$m->SetState(new PlatinumMemeberState());

$m->SetScore(1200);
echo 'Текущий член
'.$m->GetScore().'Баллы, скидки бывают:
'.$m->discount(), PHP_EOL;

$m->SetScore(990);
echo 'Текущий член
'.$m->GetScore().'Баллы, скидка составляет：'.$m->discount(), PHP_EOL;

$m->SetScore(660);
echo 'Текущий член
'.$m->GetScore().'Баллы, скидка составляет：'.$m->discount(), PHP_EOL;

$m->SetScore(10);
echo 'Текущий член
'.$m->GetScore().'Баллы, скидка составляет：'.$m->discount(), PHP_EOL;

```

> Допустим, в графическом редакторе вы выбрали инструмент «Кисть». Она меняет своё поведение в зависимости от настройки цвета: т. е. рисует линию выбранного цвета.

```php
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


```
