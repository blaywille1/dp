# Bridge / Мост

Режим моста в мире программирования на самом деле является синонимом композиции/агрегации. Почему ты это сказал? Все мы
знаем о преимуществах наследования, кто знаком с объектно-ориентированным подходом, и подклассы могут разделять многие
свойства и функции родительского класса. Однако наследование также приносит с собой проблему, которая представляет собой
серьезную связанность. Модификация родительского класса в некоторой степени повлияет на подкласс, и даже модификация
метода или свойства может привести к тому, что все подклассы изменят его снова. Это нарушает принцип открытой
инкапсуляции. Мост призван решить эту проблему, он подчеркивает использование композиции/агрегации для совместного
использования некоторых доступных методов. Я считаю, что все должны были подумать о трейте в php.Если вы использовали
эту функцию в своей работе, то вы уже использовали режим моста!

> Допустим, у вас есть сайт с несколькими страницами. Вы хотите позволить пользователям менять темы оформления страниц. Как бы вы поступили? Создали множественные копии каждой страницы для каждой темы или просто сделали отдельные темы и подгружали их в соответствии с настройками пользователей? Шаблон «Мост» позволяет реализовать второй подход.

![bridge img](https://raw.githubusercontent.com/blaywille1/dp/master/18.bridge/img/example_bridge.jpg)

## AbCD类图及解释

***

- отделение абстрактной части от части реализации, чтобы обе они могли меняться независимо друг от друга.
- Шаблон «Мост» — это предпочтение компоновки наследованию. Подробности реализации передаются из одной иерархии другому
  объекту с отдельной иерархией.

***

> AbCD类图

![桥接模式](https://raw.githubusercontent.com/blaywille1/dp/master/18.bridge/img/bridge.jpg)

```php

<?php

interface Implementor
{
    public function OperationImp();
}

class ConcreteImplementorA implements Implementor
{
    public function OperationImp()
    {
        echo 'Бетонная реализация A
', PHP_EOL;
    }
}

class ConcreteImplementorB implements Implementor
{
    public function OperationImp()
    {
        echo 'Бетонная реализация B
', PHP_EOL;
    }
}

// Давайте сначала определим интерфейсы реализации и их конкретные
// реализации, то есть функции, которые действительно должны выполняться.
// Это как Adaptee в режиме адаптера.

abstract class Abstraction
{
    protected $imp;

    public function SetImplementor(Implementor $imp)
    {
        $this->imp = $imp;
    }

    abstract public function Operation();
}

class RefinedAbstraction extends Abstraction
{
    public function Operation()
    {
        $this->imp->OperationImp();
    }
}

// Определите интерфейс абстрактного класса и сохраните ссылку на
// реализацию. В методе реализации конкретного абстрактного класса
// мы напрямую вызываем метод реальной операции, реализующий интерфейс.
// Аналогично адаптеру в адаптере.

$impA = new ConcreteImplementorA();
$impB = new ConcreteImplementorB();

$ra = new RefinedAbstraction();

$ra->SetImplementor($impA);
$ra->Operation();

$ra->SetImplementor($impB);
$ra->Operation();


```

- В объяснении исходного кода мы обнаружим, что этот режим очень похож на режим адаптера. Однако цель адаптера — помочь
  двум менее связанным классам работать вместе для выполнения промежуточных преобразований. Связывание состоит в том,
  чтобы отделить поведение метода, легко добавлять, изменять и динамически вызывать поведение, чтобы абстрактный
  интерфейс и часть реализации можно было изменять независимо друг от друга.
- Независимое изменение абстрактного интерфейса и части реализации означает, что пока сохраняется ссылка на интерфейс
  реализации, конкретный класс реализации нашего интерфейса реализации может быть совершенно другим классом с другими
  функциями и может быть изменен произвольно. Пусть реализация сама решает, что это такое.
- Преимущества режима моста: совместное использование интерфейса и его частей реализации, улучшение масштабируемости и
  прозрачность для клиента в отношении деталей реализации.
- Основная проблема, решаемая мостовым режимом, — это проблема сильной связи, вызванная непрерывным ростом наследования.
- Состав и Агрегация: Агрегация — это слабая связь, А может содержать В, но В не является частью А; композиция — это
  сильная связь, А содержит В, В также является частью А, связь между целым и частью


*

У нас есть разные модели мобильных телефонов, и каждая модель выпускает примерно одинаковые, но разные аксессуары.
Например, чехол для мобильного телефона X1, пленка, наушники; чехол для мобильного телефона X2, пленка, наушники и т. д.
Из-за ограничений по стоимости мы не будем производить совершенно разные аксессуары для каждой модели мобильного
телефона. Вместо этого попробуйте использовать внешние общие аксессуары (Implementor Исполнитель) и пусть каждая модель
мобильного телефона (Abstraction Абстракция) будет объединена (Bridge Мост) и продана потребителям. Таким образом, мы не
позволим нашему бренду мобильных телефонов исчерпать финансирование и закрыть свои двери слишком рано. Кажется, что
ведение бизнеса и изучение шаблонов проектирования действительно тесно связаны друг с другом! !

*

**
完整代码：[https://github.com/blaywille1/dp/blob/master/18.bridge/source/bridge.php](https://github.com/blaywille1/dp/blob/master/18.bridge/source/bridge.php)**

## 实例

Наша отправка SMS также может быть достигнута с помощью моста. Предположим, у нас есть много шаблонов SMS, а затем мы
используем разных провайдеров SMS для отправки SMS. В это время мы можем использовать режим моста для формирования
различных комбинаций.


> 短信发送类图

![短信发送功能桥接模式版](https://raw.githubusercontent.com/blaywille1/dp/master/18.bridge/img/bridge-message.jpg)

**
完整源码：[https://github.com/blaywille1/dp/blob/master/18.bridge/source/bridge-message.php](https://github.com/blaywille1/dp/blob/master/18.bridge/source/bridge-message.php)**

```php
<?php

interface MessageTemplate
{
    public function GetTemplate();
}

class LoginMessage implements MessageTemplate
{
    public function GetTemplate()
    {
        echo 'Ваш код подтверждения для входа - [AAA], пожалуйста, не сообщайте его другим [XXX компания]
！', PHP_EOL;
    }
}

class RegisterMessage implements MessageTemplate
{
    public function GetTemplate()
    {
        echo 'Ваш регистрационный код подтверждения [BBB], пожалуйста, не сообщайте его другим [XXX компания]
！', PHP_EOL;
    }
}

class FindPasswordMessage implements MessageTemplate
{
    public function GetTemplate()
    {
        echo 'Ваш код восстановления пароля [CCC], пожалуйста, не сообщайте его другим [XXX компания]
！', PHP_EOL;
    }
}

abstract class MessageService
{
    protected $template;

    public function SetTemplate($template)
    {
        $this->template = $template;
    }

    abstract public function Send();
}

class AliYunService extends MessageService
{
    public function Send()
    {
        echo 'Alibaba Cloud начинает отправлять SMS：';
        $this->template->GetTemplate();
    }
}

class JiGuangService extends MessageService
{
    public function Send()
    {
        echo 'Аврора начинает отправлять текстовые сообщения：';
        $this->template->GetTemplate();
    }
}

// Три шаблона SMS
$loginTemplate = new LoginMessage();
$registerTemplate = new RegisterMessage();
$findPwTemplate = new FindPasswordMessage();

// Два поставщика услуг SMS
$aliYun = new AliYunService();
$jg = new JiGuangService();

// Случайная комбинация
// Аврора отправь регистрационное СМС
$jg->SetTemplate($registerTemplate);
$jg->Send();

// Alibaba Cloud отправляет SMS для входа в систему
$aliYun->SetTemplate($loginTemplate);
$aliYun->Send();

// Alibaba Cloud отправляет SMS с паролем
$aliYun->SetTemplate($findPwTemplate);
$aliYun->Send();

// Аврора отправляет СМС для входа
$jg->SetTemplate($loginTemplate);
$jg->Send();

// ......


```

> 说明

- Это режим агрегации. Шаблоны не являются частью отправки SMS, мы можем отправлять их напрямую, не используя шаблоны,
  они не имеют сильной связи.
- Способ отправки отправителя SMS менять не нужно, нужно только импортировать разные шаблоны SMS, чтобы реализовать
  быструю отправку различных шаблонов.
- В случае неуверенности в том, должно ли это быть отношение «является», рекомендуется использовать метод проектирования
  комбинированной/агрегационной формы режима моста.Если определено, что текущее отношение класса равно «а», то не
  стесняйтесь использовать наследование.

> Реализуем вышеописанный пример с веб-страницами. Сделаем иерархию WebPage:

```php
<?php

//Реализуем вышеописанный пример с веб-страницами.
// Сделаем иерархию WebPage:


interface WebPage
{
    public function __construct(Theme $theme);

    public function getContent();
}

interface Theme
{
    public function getColor();
}

class About implements WebPage
{
    protected $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    public function getContent()
    {
        return "About page in ".$this->theme->getColor();
    }
}

//Отделим иерархию тем:

class Careers implements WebPage
{
    protected $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    public function getContent()
    {
        return "Careers page in ".$this->theme->getColor();
    }
}

class DarkTheme implements Theme
{
    public function getColor()
    {
        return 'Dark Black';
    }
}

class LightTheme implements Theme
{
    public function getColor()
    {
        return 'Off white';
    }
}

class AquaTheme implements Theme
{
    public function getColor()
    {
        return 'Light blue';
    }
}

//Обе иерархии:


$darkTheme = new DarkTheme();

$about = new About($darkTheme);
$careers = new Careers($darkTheme);

echo $about->getContent(); // "About page in Dark Black";
echo $careers->getContent(); // "Careers page in Dark Black";

```


