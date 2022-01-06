## Меморандумный режим / memento / Хранитель

Другой пример - Git или Svn, инструмент управления кодом, который наши программисты используют каждый день. Каждая
отправка похожа на резервную копию архива. Если есть проблема с новым кодом, просто откатитесь и восстановите. Это
типичные применения режима памятки,

> В качестве примера можно привести калькулятор («создатель»), у которого любая последняя выполненная операция сохраняется в памяти («хранитель»), чтобы вы могли снова вызвать её с помощью каких-то кнопок («опекун»).


***

- при условии, что инкапсуляция не разрушается, фиксируйте внутреннее состояние объекта и сохраняйте это состояние вне
  объекта. Таким образом, объект может быть восстановлен в исходное состояние в будущем.
- Шаблон «Хранитель» фиксирует и хранит текущее состояние объекта, чтобы оно легко восстанавливалось.

***

> AbCD类图

![备忘录模式](https://raw.githubusercontent.com/blaywille1/dp/master/17.memento/img/memento.jpg)

```php
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

```

В вызове клиента наш создатель инициализировал состояние и сохранил его, а затем искусственно изменил состояние. На
данный момент вам нужно только восстановить статус через ответственное лицо.

- Грубо говоря, режим памятки позволяет внешнему классу B сохранять внутреннее состояние A, а затем удобно
  восстанавливать это состояние в подходящее время.
- На самом деле существует множество сценариев приложений для режима заметок, таких как откат браузера, резервное
  копирование и восстановление базы данных, резервное копирование и восстановление операционной системы, отмена и повтор
  документа, сожаление о шахматной игре и т. Д.
- Этот режим может поддерживать инкапсуляцию создателя, то есть эти состояния должны быть скрыты от внешних объектов,
  поэтому они могут быть переданы только объекту памятки для записи.
- Копирование состояния между отправителем и памяткой может вызвать проблемы с производительностью, особенно сложное
  внутреннее состояние больших объектов, а также может привести к некоторым уязвимостям кодирования, таким как
  отсутствие некоторых состояний.

*
Mac的时光机功能大家有了解过吧，可以将电脑恢复到某一时间点的状态下。其实windows的ghost也是类似的功能。我们的手机操作系统上也决定开发这样的一个功能。当我们点击时光机备份时，将手机上所有的资料、数据、状态信息都压缩保存起来，如果用户允许的话，我们将这个压缩包上传到我们的云服务器上避免占用用户的手机内存，否则就只能保存到用户的手机内存中了。当用户的手机需要恢复到某个时间点，我们将所有的时光机备份列出，用户只需要用手指轻轻一按就可以把手机系统状态恢复到当时的样子了，是不是非常方便！！*

**
完整代码：[https://github.com/blaywille1/dp/blob/master/17.memento/source/memento.php](https://github.com/blaywille1/dp/blob/master/17.memento/source/memento.php)**

## 实例

这次又回到短信发送的例子上来。通常我们做短信或者邮件发送这些功能时，会有一个队列从数据库或者缓存中读取要发送的内容进行发送，如果成功了就不管了，如果失败了会将短信的状态改成失败或者重发。在这里，我们直接将它改回到之前未发送的状态然后等待下次发送的队列再次执行发送。

> 短信发送类图

![短信发送功能备忘录模式版](https://raw.githubusercontent.com/blaywille1/dp/master/17.memento/img/memento-message.jpg)

**
完整源码：[https://github.com/blaywille1/dp/blob/master/17.memento/source/memento-message.php](https://github.com/blaywille1/dp/blob/master/17.memento/source/memento-message.php)**

```php
<?php

class Message
{
    private $content;
    private $to;
    private $state;
    private $time;

    public function __construct($to, $content)
    {
        $this->to = $to;
        $this->content = $content;
        $this->state = 'еще не отправлено';
        $this->time = time();
    }

    public function Show()
    {
        echo $this->to, '---', $this->content, '---', $this->time, '---', $this->state, PHP_EOL;
    }

    public function CreateSaveSate()
    {
        $ss = new SaveState();
        $ss->SetState($this->state);
        return $ss;
    }

    public function SetSaveState($ss)
    {
        if ($this->state != $ss->GetState()) {
            $this->time = time();
        }
        $this->state = $ss->GetState();
    }

    public function SetState($state)
    {
        $this->state = $state;
    }

    public function GetState()
    {
        return $this->state;
    }

}

class SaveState
{
    private $state;
    public function SetState($state)
    {
        $this->state = $state;
    }
    public function GetState()
    {
        return $this->state;
    }
}

class StateContainer
{
    private $ss;
    public function SetSaveState($ss)
    {
        $this->ss = $ss;
    }
    public function GetSaveState()
    {
        return $this->ss;
    }
}

// Имитировать отправку SMS
$mList = [];
$scList = [];
for ($i = 0; $i < 10; $i++) {
    $m = new Message('Телефонный номер' . $i, 'содержание' . $i);
    echo 'Начальное состояние：';
    $m->Show();

    // Сохраните исходную информацию
    $sc = new StateContainer();
    $sc->SetSaveState($m->CreateSaveSate());
    $scList[] = $sc;

    // Имитация отправки SMS, 2 отправлены успешно, 3 отправлены не удалось
    $pushState = mt_rand(2, 3);
    $m->SetState($pushState == 2 ? 'Успешно отправлено
' : 'Не удалось отправить
');
    echo 'Статус после релиза：';
    $m->Show();

    $mList[] = $m;
}

// Смоделируйте другой поток, чтобы найти неудавшуюся отправку
// и восстановить их в неотправленное состояние
sleep(2);
foreach ($mList as $k => $m) {
    if ($m->GetState() == 'Не удалось отправить') { // Если не удалось отправить, восстановить статус
        $m->SetSaveState($scList[$k]->GetSaveState());
    }
    echo 'Запросить статус после сбоя публикации：';
    $m->Show();
}

```

- SMS в качестве отправителя, сохраните текущий статус отправки перед отправкой
- Случайная имитация отправки SMS, только два статуса, успешная или неудачная отправка и изменение статуса отправителя
  на успешное или неудачное.
- Смоделируйте другой поток или сценарий, чтобы проверить статус отправки SMS, если он обнаружит какой-либо сбой, затем
  измените его обратно на неотправленный статус.
- Здесь мы сохраняем только поле статуса отправки, внутренние атрибуты других отправителей не сохраняются.
- В реальном сценарии у нас должно быть ограничение на количество повторных попыток. Когда это количество раз будет
  превышено, статус изменится на полный сбой передачи и больше никаких повторных попыток.

```php
<?php

//Текстовый редактор время от времени сохраняет своё состояние,
// чтобы можно было восстановить текст в каком-то прошлом виде.


//Сначала создадим объект «хранитель», в котором можно сохранять
// состояние редактора.


class EditorMemento
{
    protected $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
}

//Теперь сделаем редактор («создатель»), который будет использовать
// объект «хранитель».


class Editor
{
    protected $content = '';

    public function type(string $words)
    {
        $this->content = $this->content.' '.$words;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function save()
    {
        return new EditorMemento($this->content);
    }

    public function restore(EditorMemento $memento)
    {
        $this->content = $memento->getContent();
    }
}

//Использование:


$editor = new Editor();

// Пишем что-нибудь
$editor->type('This is the first sentence.');
$editor->type('This is second.');

// Сохранение состояния в: This is the first sentence. This is second.
$saved = $editor->save();

// Пишем ещё
$editor->type('And this is third.');

// Output: Содержимое до сохранения
echo $editor->getContent(); // This is the first sentence. This is second. And this is third.

// Восстанавливаем последнее сохранённое состояние
$editor->restore($saved);

$editor->getContent(); // This is the first sentence. This is second.

```

