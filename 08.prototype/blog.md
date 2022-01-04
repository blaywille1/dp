Режим прототипа на самом деле более ярко называется режимом клонирования. Его основное поведение - клонировать объект,
но клонированный объект называется исходным прототипом, поэтому и называется этот режим. Честно говоря, с точки зрения
использования, действительно кажется более подходящим называть режим клонирования.

- используйте экземпляры прототипов, чтобы указать типы создаваемых объектов, и создавайте новые объекты путем
  копирования этих прототипов.
- Помните клонированную овечку Долли? Так вот, этот шаблон проектирования как раз посвящён клонированию.
- Когда использовать? Когда необходимый объект аналогичен уже существующему или когда создание с нуля дороже
  клонирования

![原型模式](https://raw.githubusercontent.com/blaywille1/dp/master/08.prototype/img/prototype.jpg)

```php
<?php

abstract class Prototype
{
    public $v = 'clone'.PHP_EOL;

    public function __construct()
    {
        echo 'create'.PHP_EOL;
    }

    abstract public function __clone();
}

class ConcretePrototype1 extends Prototype
{
    public function __clone()
    {
    }
}

class ConcretePrototype2 extends Prototype
{
    public function __clone()
    {
    }
}

/*
 * 
 * Кажется, что режим прототипа копирует один и тот же объект, 
 * но обратите внимание, что при копировании метод __construct () 
 * не вызывается, то есть, когда вы запускаете этот код, 
 * создавайте только выходы один раз. Это раскрывает одну из самых
 *  важных особенностей режима прототипа - снижение стоимости создания 
 * объектов .

Основываясь на приведенных выше характеристиках, мы можем быстро 
скопировать большое количество одинаковых объектов, например, когда 
большое количество одинаковых объектов помещается в массив.
 
 */

class Client
{
    public function operation()
    {
        $p1 = new ConcretePrototype1();
        $p2 = clone $p1;

        echo $p1->v;
        echo $p2->v;

        // $p2->v = 123;
        // echo $p1->v;
        // echo $p2->v;

        echo $p1 == $p2 ? "true" : 'false', PHP_EOL;
        echo $p1 === $p2 ? "true" : 'false', PHP_EOL;
    }
}

$c = new Client();
$c->operation();

```

> 原型模式生产手机类图

![原型模式生产手机](https://raw.githubusercontent.com/blaywille1/dp/master/08.prototype/img/prototype-phone.jpg)

## Пример

в этой партии мобильных телефонов нет никакой разницы, большинство из них имеют одинаковую конфигурацию,... и иногда
могут быть различия в процессоре и памяти некоторых моделей. В настоящее время мы можем использовать режим прототипа,
чтобы быстро скопировать и изменить только некоторые различия.

**
完整源码：[https://github.com/blaywille1/dp/blob/master/08.prototype/source/prototype-phone.php](https://github.com/blaywille1/dp/blob/master/08.prototype/source/prototype-phone.php)**

```php
<?php

interface ServiceProvicer
{
    public function getSystem();
}

class ChinaMobile implements ServiceProvicer
{
    public $system;

    public function getSystem()
    {
        return "China Mobile".$this->system;
    }
}

class ChinaUnicom implements ServiceProvicer
{
    public $system;

    public function getSystem()
    {
        return "China Unicom".$this->system;
    }
}

class Phone
{
    public $service_province;
    public $cpu;
    public $rom;
}

class CMPhone extends Phone
{
    function __clone()
    {
        // $this->service_province = new ChinaMobile();
    }
}

class CUPhone extends Phone
{
    function __clone()
    {
        $this->service_province = new ChinaUnicom();
    }
}


$cmPhone = new CMPhone();
$cmPhone->cpu = "1.4G";
$cmPhone->rom = "64G";
$cmPhone->service_province = new ChinaMobile();
$cmPhone->service_province->system = 'TD-CDMA';
$cmPhone1 = clone $cmPhone;
$cmPhone1->service_province->system = 'TD-CDMA1';

var_dump($cmPhone);
var_dump($cmPhone1);
echo $cmPhone->service_province->getSystem();
echo $cmPhone1->service_province->getSystem();


$cuPhone = new CUPhone();
$cuPhone->cpu = "1.4G";
$cuPhone->rom = "64G";
$cuPhone->service_province = new ChinaUnicom();
$cuPhone->service_province->system = 'WCDMA';
$cuPhone1 = clone $cuPhone;
$cuPhone1->rom = "128G";
$cuPhone1->service_province->system = 'WCDMA1';

var_dump($cuPhone);
var_dump($cuPhone1);
echo $cuPhone->service_province->getSystem();
echo $cuPhone1->service_province->getSystem();

```

```php
<?php

class Sheep
{
    protected $name;
    protected $category;

    public function __construct(
        string $name,
        string $category = 'Mountain Sheep'
    ) {
        $this->name = $name;
        $this->category = $category;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(string $category)
    {
        $this->category = $category;
    }
}

//Затем можно клонировать так:


$original = new Sheep('Jolly');
echo $original->getName(); // Джолли
echo $original->getCategory(); // Горная овечка

// Клонируйте и модифицируйте, что нужно
$cloned = clone $original;
$cloned->setName('Dolly');
echo $cloned->getName(); // Долли
echo $cloned->getCategory(); // Горная овечка

//Также для модификации процедуры клонирования можно обратиться к
// магическому методу __clone.

```
