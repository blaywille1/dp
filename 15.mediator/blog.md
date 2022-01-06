## Посредник / Промежуточный шаблон

Поскольку долгосрочная аренда необходима из-за изменений в работе или жизни, неизбежно иметь дело с агентствами
недвижимости один раз в один, два или три-пять лет. Иногда мы снимаем дом и не обязательно знаем информацию о владельце,
и владельцу не нужно знать нашу информацию, и все это обрабатывается посредником. Здесь посредник стал нашим
коммуникационным мостом.Эта ситуация на самом деле похожа на домовладельца, который уехал за границу или должен чем-то
заняться за пределами страны и полностью доверяет дом в руках посредника. Подобно этой ситуации, в мире кода это
типичное применение шаблона посредника.

> Шаблон «Посредник» подразумевает добавление стороннего объекта («посредника») для управления взаимодействием между двумя объектами («коллегами»). Шаблон помогает уменьшить связанность (coupling) классов, общающихся друг с другом, ведь теперь они не должны знать о реализациях своих собеседников.

```php
<?php

//Простейший пример: чат(«посредник»), в котором пользователи(«коллеги») отправляют друг другу сообщения
//.


//Создадим «посредника»:


interface ChatRoomMediator
{
    public function showMessage(User $user, string $message);
}

// Посредник
class ChatRoom implements ChatRoomMediator
{
    public function showMessage(User $user, string $message)
    {
        $time = date('M d, y H:i');
        $sender = $user->getName();

        echo $time.'['.$sender.']:'.$message;
    }
}

//Теперь создадим «коллег»:


class User
{
    protected $name;
    protected $chatMediator;

    public function __construct(string $name, ChatRoomMediator $chatMediator)
    {
        $this->name = $name;
        $this->chatMediator = $chatMediator;
    }

    public function getName()
    {
        return $this->name;
    }

    public function send($message)
    {
        $this->chatMediator->showMessage($this, $message);
    }
}

//Использование:


$mediator = new ChatRoom();

$john = new User('John Doe', $mediator);
$jane = new User('Jane Doe', $mediator);

$john->send('Hi there!');
$jane->send('Hey!');

// Выходной вид
// Feb 14, 10:58 [John]: Hi there!
// Feb 14, 10:58 [Jane]: Hey!

```

## AbCD类图及解释

***

- используйте промежуточный объект для инкапсуляции серии взаимодействий с объектами. Посредник заставляет объекты не
  ссылаться друг на друга явно, тем самым ослабляя связь, и может независимо изменять взаимодействие между ними

***

> AbCD类图

![中介者模式](https://raw.githubusercontent.com/blaywille1/dp/master/15.mediator/img/mediator.jpg)

```php
<?php

abstract class Mediator
{
    abstract public function Send(string $message, Colleague $colleague);
}

class ConcreteMediator extends Mediator
{
    public $colleague1;
    public $colleague2;

    public function Send(string $message, Colleague $colleague)
    {
        if ($colleague == $this->colleague1) {
            $this->colleague2->Notify($message);
        } else {
            $this->colleague1->Notify($message);
        }
    }
}

// Абстрагированный посредник и конкретная реализация.Здесь мы предполагаем,
// что есть два фиксированных класса коллег, чтобы они могли общаться
// друг с другом, поэтому, когда входящий коллега равен 1,
// вызывается метод Notify 2, что эквивалентно разрешению 2 получать
// Сообщение от 1

abstract class Colleague
{
    protected $mediator;

    public function __construct(Mediator $mediator)
    {
        $this->mediator = $mediator;
    }

}

class ConcreteColleague1 extends Colleague
{
    public function Send(string $message)
    {
        $this->mediator->Send($message, $this);
    }

    public function Notify(string $message)
    {
        echo "Коллега 1 получает информацию
：".$message, PHP_EOL;
    }
}

class ConcreteColleague2 extends Colleague
{
    public function Send(string $message)
    {
        $this->mediator->Send($message, $this);
    }

    public function Notify(string $message)
    {
        echo "Коллега 2 получает информацию
：".$message;
    }
}

// Класс коллег и конкретная реализация, мы хотим здесь подтвердить,
// что каждый класс коллег знает только посредника и не знает другого
// класса коллег. Это характеристика посредника, и обеим сторонам
// не нужно знать каждый разное.

$m = new ConcreteMediator();

$c1 = new ConcreteColleague1($m);
$c2 = new ConcreteColleague2($m);

$m->colleague1 = $c1;
$m->colleague2 = $c2;

$c1->Send("не ел ли ты еще？");
$c2->Send("Нет, вы планируете лечить?
");

```

- Считаете ли вы, что эта модель очень подходит для создания некоторых коммуникационных продуктов? Да, социальный чат,
  sns, прямая трансляция и т. Д. Подходят, потому что этот режим предназначен для отделения пользователей от
  пользователей, не требуя от пользователя поддержки всех связанных пользовательских объектов.
- Поскольку пользователям нет необходимости поддерживать отношения, проблема обслуживания «многие ко многим» между
  отношениями решается путем. В то же время нет необходимости изменять класс пользователя, чтобы изменить отношение,
  поддерживая хорошая инкапсуляция пользовательского класса
- Однако централизованное обслуживание посредника может сделать эту категорию слишком сложной и большой.
- Следовательно, модель не является панацеей, вы должны выяснить бизнес-сценарий и использовать его в качестве
  компромисса.
- Посредник подходит для ситуаций, когда группа объектов взаимодействует четко определенным, но сложным образом, и когда
  вы хотите настроить поведение, которое распределено по нескольким классам, но вы не хотите создавать слишком много
  подклассов.

*Как предприниматель я знаю важность управления проектами, и руководитель проекта во многих случаях выступает в роли
посредника. С организационной точки зрения, в начале и в конце проекта мне как начальнику не нужно заботиться о том, кто
отвечает за реализацию. Человек, с которым я хочу общаться, - это только руководитель проекта. Таким же образом другие
вспомогательные отделы включают в себя финансы, персонал, администрацию и т. Д. Их не волнует, кто пишет код, им нужно
только общаться с менеджером проекта, чтобы понять ситуацию с проектом и контент, который должен быть сотрудничал. Что
насчет того, кто пишет код в команде проекта? Вам не нужно знать, кто будет платить ему зарплату или где проблема с
посещаемостью, просто оставьте ее решать руководителю проекта. Таким образом, разработка системы ответственности
менеджера проекта является типичным применением модели посредничества. Причина, по которой наша фабрика мобильных
телефонов так быстро развивалась, также связана с этими руководителями проектов, которые пригласили их пообедать
вечером ~~~

*

**
完整代码：[https://github.com/blaywille1/dp/blob/master/15.mediator/source/mediator.php](https://github.com/blaywille1/dp/blob/master/15.mediator/source/mediator.php)**

## пример

В этот раз мы не будем отправлять текстовые сообщения, давайте создадим чат. Простая онлайн-комната для чата, требование
состоит в том, чтобы позволить пользователям, которые входят в чат-комнату, общаться в чате онлайн, давайте посмотрим,
как использовать промежуточный режим, чтобы реализовать эту чат-комнату!


> 聊天室类图

![聊天室功能中介者模式版](https://raw.githubusercontent.com/blaywille1/dp/master/15.mediator/img/mediator-chat.jpg)

**
完整源码：[https://github.com/blaywille1/dp/blob/master/15.mediator/source/mediator-webchat.php](https://github.com/blaywille1/dp/blob/master/15.mediator/source/mediator-webchat.php)**

```php
<?php

abstract class Mediator
{
    abstract public function Send($message, $user);
}

class ChatMediator extends Mediator
{
    public $users = [];

    public function Attach($user)
    {
        if ( ! in_array($user, $this->users)) {
            $this->users[] = $user;
        }
    }

    public function Detach($user)
    {
        $position = 0;
        foreach ($this->users as $u) {
            if ($u == $user) {
                unset($this->users[$position]);
            }
            $position++;
        }
    }

    public function Send($message, $user)
    {
        foreach ($this->users as $u) {
            if ($u == $user) {
                continue;
            }
            $u->Notify($message);
        }
    }
}

abstract class User
{
    public $mediator;
    public $name;

    public function __construct($mediator, $name)
    {
        $this->mediator = $mediator;
        $this->name = $name;
    }
}

class ChatUser extends User
{
    public function Send($message)
    {
        $this->mediator->Send($message.'('.$this->name.'Отправить)', $this);
    }

    public function Notify($message)
    {
        echo $this->name.'Получил новости：'.$message, PHP_EOL;
    }
}

$m = new ChatMediator();

$u1 = new ChatUser($m, 'Пользователь 1
');
$u2 = new ChatUser($m, 'Пользователь 2
');
$u3 = new ChatUser($m, 'Пользователь 3
');

$m->Attach($u1);
$m->Attach($u3);
$m->Attach($u2);

$u1->Send('Hello, всем привет
！'); // Пользователь 2 и пользователь 3 получают сообщение


$u2->Send('Привет！'); // Пользователь 1, пользователь 3 получают сообщение


$m->Detach($u2); // Пользователь 2 выходит из чата


$u3->Send('Добро пожаловать！'); // Пользователь 1 получает сообщение


```
