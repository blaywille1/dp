## Режим построения / builder / Шаблонный метод

Режим построителя также можно назвать режимом генератора. Первоначальное значение слова "строитель" включает в себя
значения "строитель", "разработчик" и "создатель". Очевидно, что этот режим является еще одним творческим режимом для
создания объектов. Так каковы его характеристики? С архитектурной точки зрения, строительство дома - это не
строительство дома сразу, а его строительство по кирпичику. В доме есть не только кирпич и плитка, но также различные
трубы, различные провода и т. Д., Которые составляют дом. Можно сказать, что режим строителя - это очень яркий процесс
формирования объекта (дома) из различных частей.


***

- отделяйте построение сложного объекта от его представления, чтобы один и тот же процесс построения мог создавать
  разные представления.
- «Шаблонный метод» определяет каркас выполнения определённого алгоритма, но реализацию самих этапов делегирует дочерним
  классам.

***

> AbCD类图

![建造者模式](https://raw.githubusercontent.com/blaywille1/dp/master/16.builder/img/builder.jpg)

```php

<?php

class Product
{
    private $parts = [];

    public function Add(String $part): void
    {
        $this->parts[] = $part;
    }

    public function Show(): void
    {
        echo PHP_EOL . 'Создание продукта
 ----', PHP_EOL;
        foreach ($this->parts as $part) {
            echo $part, PHP_EOL;
        }
    }
}

// Категория продукта, вы можете думать о ней как о доме, который
// мы хотим построить. В настоящее время в доме нет содержимого,
// и нам нужно внести в него свой вклад.

interface Builder
{
    public function BuildPartA(): void;
    public function BuildPartB(): void;
    public function GetResult(): Product;
}

class ConcreteBuilder1 implements Builder
{
    private $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function BuildPartA(): void
    {
        $this->product->Add('Часть А
');
    }
    public function BuildPartB(): void
    {
        $this->product->Add('Часть B');
    }
    public function GetResult(): Product
    {
        return $this->product;
    }
}

class ConcreteBuilder2 implements Builder
{
    private $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function BuildPartA(): void
    {
        $this->product->Add('Часть X
');
    }
    public function BuildPartB(): void
    {
        $this->product->Add('Вечеринка');
    }
    public function GetResult(): Product
    {
        return $this->product;
    }
}

// Строительная абстракция и ее реализация. Разные разработчики всегда
// выбирают разные фирменные материалы.У нас есть два разных разработчика,
// но их цель одна и та же, оба - построить дом (продукт).

class Director
{
    public function Construct(Builder $builder)
    {
        $builder->BuildPartA();
        // $builder->BuildPartB();
    }
}

/*
Конструктор, используемый для вызова строителя на производство.

 Правильно, это наша команда инженеров. Он выбирает материалы и строит.

Одна и та же команда инженеров может выполнять разные заказы, но все,
 что они строят, - это дома. Просто материалы и внешний вид у этого дома
разные, а мастерство в целом осталось прежним.

*/
$director = new Director();
$b1 = new ConcreteBuilder1();
$b2 = new ConcreteBuilder2();

$director->Construct($b1);
$p1 = $b1->getResult();
$p1->Show();

$director->Construct($b2);
$p2 = $b2->getResult();
$p2->Show();


```

- Фактически, основная проблема, которую необходимо решить с помощью этого режима, заключается в том, что у класса может
  быть множество конфигураций и атрибутов. Эти конфигурации и атрибуты необязательно настраивать. Настроить эти вещи с
  помощью одноразового экземпляра очень сложно. . В настоящее время вы можете подумать о том, чтобы сделать эти
  конфигурации и атрибуты частью, которую можно добавить в любое время. Получите разные объекты с помощью различных
  комбинаций атрибутов.
- Исходный текст вышеупомянутой статьи в GoF таков: он позволяет вам изменить внутреннее представление продукта; он
  отделяет код построения от кода представления; он позволяет вам иметь более точный контроль над процессом
  строительства.
- Проще говоря, объект слишком сложный, мы можем собрать его по частям!
- Немного знать о разработке под Android не будет незнакомым, создав объект диалога AlterDialog.builder
- В Laravel компонент базы данных также использует режим построителя.Вы можете проверить, есть ли Builder.php в
  каталогах Database \ Eloquent и Database \ Query в исходном коде.

*Всем известно, что сборка мобильного телефона - сложный процесс, поэтому у нас есть соответствующие чертежи (
Конструктор/Builder) для разных моделей мобильных телефонов. Дайте чертежи и комплектующие рабочим (директору) на
сборочной линии, и они будут использовать комплектующие соответственно к чертежам.Для производства всех необходимых нам
типов мобильных телефонов (Продукт). Очевидно, что все мы великие строители, вносящие свой вклад в нашу отрасль! ! !

*

**
完整代码：[https://github.com/blaywille1/dp/blob/master/16.builder/source/builder.php](https://github.com/blaywille1/dp/blob/master/16.builder/source/builder.php)**

```php
<?php

interface Builder
{
    public function BuildAttribute($attr);

    public function BuildButton($button);

    public function BuildTitle($title);

    public function BuildContent($content);

    public function GetDialog();
}

class Dialog
{
    private $attributes = [];
    private $buttons = [];
    private $title = '';
    private $content = '';

    public function AddAttributes($attr)
    {
        $this->attributes[] = $attr;
    }

    public function AddButtons($button)
    {
        $this->buttons[] = $button;
    }

    public function SetTitle($title)
    {
        $this->title = $title;
    }

    public function SetContent($content)
    {
        $this->content = $content;
    }

    public function ShowDialog()
    {
        echo PHP_EOL, 'Показать окно подсказки
 === ', PHP_EOL;
        echo 'заглавие：'.$this->title, PHP_EOL;
        echo 'содержание：'.$this->content, PHP_EOL;
        echo 'стиль：'.implode(',', $this->attributes), PHP_EOL;
        echo 'Кнопка：'.implode(',', $this->buttons), PHP_EOL;
    }
}

class DialogBuilder implements Builder
{
    private $dialog;

    public function __construct()
    {
        $this->dialog = new Dialog();
    }

    public function BuildAttribute($attr)
    {
        $this->dialog->AddAttributes($attr);
    }

    public function BuildButton($button)
    {
        $this->dialog->AddButtons($button);
    }

    public function BuildTitle($title)
    {
        $this->dialog->SetTitle($title);
    }

    public function BuildContent($content)
    {
        $this->dialog->SetContent($content);
    }

    public function GetDialog()
    {
        return $this->dialog;
    }
}

class DialogDirector
{
    public function Construct($title, $content)
    {

        $builder = new DialogBuilder();

        $builder->BuildAttribute('Положить сверху
');
        $builder->BuildAttribute('Центральный дисплей
');

        $builder->BuildButton('подтверждать');
        $builder->BuildButton('Отмена');

        $builder->BuildTitle($title);
        $builder->BuildContent($content);

        return $builder;
    }
}

class ModalDialogDirector
{
    public function Construct($title, $content)
    {

        $builder = new DialogBuilder();

        $builder->BuildAttribute('Положить сверху
');
        $builder->BuildAttribute('Центральный дисплей
');
        $builder->BuildAttribute('Фоновые снимки
');
        $builder->BuildAttribute('Внешне некликабельный
');

        $builder->BuildButton('подтверждать
');
        $builder->BuildButton('Отмена');

        $builder->BuildTitle($title);
        $builder->BuildContent($content);

        return $builder;
    }
}

$d1 = new DialogDirector();
$d1->Construct('Окно 1
', 'Вы уверены, что хотите выполнить операцию A?
')->GetDialog()->ShowDialog();

$d2 = new ModalDialogDirector();
$d2->Construct('Окно 2
', 'Вы уверены, что хотите выполнить операцию B.？')->GetDialog()->ShowDialog();

```

- На этот раз наш продукт немного сложен, с заголовком, содержанием, атрибутами, кнопками и т. Д.
- Процесс построения практически такой же, но здесь мы в основном используем разные конструкторы. Можно щелкать объекты
  за пределами обычных диалоговых окон, в то время как модальные окна обычно имеют маскирующий слой, то есть фон
  становится прозрачным и черным, а объекты за пределами больше нельзя щелкать
- Если вы создаете экземпляр класса окна непосредственно через метод построения каждый раз, будет передаваться много
  параметров, и теперь мы можем использовать построитель для объединения, чтобы объект имел полиморфный эффект и мог
  представлять различные формы. и особенности

```php
<?php

//Допустим, у нас есть программный инструмент,
// позволяющий тестировать, проводить контроль качества кода (lint),
// выполнять сборку, генерировать отчёты сборки (отчёты о покрытии кода,
// о качестве кода и т. д.), а также развёртывать приложение на тестовом
// сервере.


//Сначала наш базовый класс определяет каркас алгоритма сборки.


abstract class Builder
{

    // Шаблонный метод
    final public function build()
    {
        $this->test();
        $this->lint();
        $this->assemble();
        $this->deploy();
    }

    abstract public function test();

    abstract public function lint();

    abstract public function assemble();

    abstract public function deploy();
}

//Теперь создаём реализации:


class AndroidBuilder extends Builder
{
    public function test()
    {
        echo 'Running android tests';
    }

    public function lint()
    {
        echo 'Linting the android code';
    }

    public function assemble()
    {
        echo 'Assembling the android build';
    }

    public function deploy()
    {
        echo 'Deploying android build to server';
    }
}

class IosBuilder extends Builder
{
    public function test()
    {
        echo 'Running ios tests';
    }

    public function lint()
    {
        echo 'Linting the ios code';
    }

    public function assemble()
    {
        echo 'Assembling the ios build';
    }

    public function deploy()
    {
        echo 'Deploying ios build to server';
    }
}

//Использование:


$androidBuilder = new AndroidBuilder();
$androidBuilder->build();

// Output:
// Выполнение Android-тестов
// Линтинг Android-кода
// Создание Android-сборки
// Развёртывание Android-сборки на сервере

$iosBuilder = new IosBuilder();
$iosBuilder->build();

// Output:
// Выполнение iOS-тестов
// Линтинг iOS-кода
// Создание iOS-сборки
// Развёртывание iOS-сборки на сервере

```
