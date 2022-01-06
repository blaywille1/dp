## Composite / композит (компоновщик) / Комбинированный режим

Интернет-компании пользуются популярностью в плоском менеджменте, то есть уровень управления должен быть меньше или не
больше трех уровней.Для низкоуровневого программиста разница между вашим генеральным директором и вашим рангом находится
в пределах трех уровней. Однако многие традиционные предприятия имеют очень глубокие иерархические отношения.С точки
зрения структуры данных эта организационная структура, сгруппированная по функциям, очень похожа на дерево. Роль
комбинированной модели, которую мы представили сегодня, очень похожа на эту модель уровня корпоративной организационной
структуры.

## AbCD类图及解释

***

- объединение объектов в древовидную структуру для представления иерархической структуры «часть-целое». Composite
  позволяет пользователям согласованно использовать отдельные объекты и комбинированные объекты.
- Каждая компания состоит из сотрудников. У каждого сотрудника есть одни и те же свойства: зарплата, обязанности,
  отчётность перед кем-то, субординация...

- Вкратце. Шаблон «Компоновщик» позволяет клиентам обрабатывать отдельные объекты в едином порядке.

***

> AbCD类图

![组合模式](https://raw.githubusercontent.com/blaywille1/dp/master/14.composite/img/composite.jpg)

```php
<?php

abstract class Component
{
    protected $name;

    public function __construct($name){
        $this->name = $name;
    }

    abstract public function Operation(int $depth);

    abstract public function Add(Component $component);

    abstract public function Remove(Component $component);
}

// Объявление абстрактного составного узла реализует поведение по
//   умолчанию открытого интерфейса всех классов при соответствующих
// обстоятельствах и является родительским классом для всех дочерних узлов.

class Composite extends Component
{
    private $componentList;

    public function Operation($depth)
    {
        echo str_repeat('-', $depth) . $this->name . PHP_EOL;
        foreach ($this->componentList as $component) {
            $component->Operation($depth + 2);
        }
    }

    public function Add(Component $component)
    {
        $this->componentList[] = $component;
    }

    public function Remove(Component $component)
    {
        $position = 0;
        foreach ($this->componentList as $child) {
            if ($child == $component) {
                array_splice($this->componentList, ($position), 1);
            }
            ++$position;
        }
    }

    public function GetChild(int $i)
    {
        return $this->componentList[$i];
    }
}

// Конкретный класс реализации узла сохраняет ссылки подчиненных
// узлов и определяет фактическое поведение узла.

class Leaf extends Component
{
    public function Add(Component $c)
    {
        echo 'Cannot add to a leaf' . PHP_EOL;
    }
    public function Remove(Component $c)
    {
        echo 'Cannot remove from a leaf' . PHP_EOL;
    }
    public function Operation(int $depth)
    {
        echo str_repeat('-', $depth) . $this->name . PHP_EOL;
    }
}

$root = new Composite("root");
$root->Add(new Leaf("Leaf A"));
$root->Add(new Leaf("Leaf B"));

$comp = new Composite("Composite X");
$comp->Add(new Leaf("Leaf XA"));
$comp->Add(new Leaf("Leaf XB"));

$root->Add($comp);

$comp2 = new Composite("Composite XY");
$comp2->Add(new Leaf("Leaf XYA"));
$comp2->Add(new Leaf("Leaf XYB"));

$comp->Add($comp2);

$root->Add(new Leaf("Leaf C"));

$leaf = new Leaf("Leaf D");
$root->Add($leaf);
$root->remove($leaf);

$root->Operation(1);

```

Листовой узел, последний узел без дочерних узлов.

- С точки зрения кода это полностью реализация дерева
- Все дочерние узлы и листовые узлы могут обрабатывать данные, но конечный узел является конечной точкой.
- Вы хотите, чтобы пользователи игнорировали разницу между комбинированным объектом и отдельным объектом. Когда вы
  используете все объекты в комбинированной структуре единообразно, вам следует рассмотреть возможность использования
  комбинированного режима.
- Пользователю не нужно заботиться о том, обрабатывать ли листовой узел или составной компонент, и нет необходимости
  писать некоторые заявления о выборе для определения композиции.
- Комбинированный режим позволяет клиентам последовательно использовать комбинированную структуру и единый объект.

**
完整代码：[https://github.com/blaywille1/dp/blob/master/14.composite/source/composite.php](https://github.com/blaywille1/dp/blob/master/14.composite/source/composite.php)**

## пример

SMS сообщение, эту функцию можно использовать снова и снова. Этот раз не исключение. На этот раз бэкэнд-функция нашего
веб-сайта заключается в отправке коротких сообщений пользователям с разных подсайтов и из разных источников. Здесь мы
по-прежнему сосредоточены только на отправке SMS. Мы надеемся предоставить вам пользователей, которые имеют разные роли
в каналах, но имеют унифицированное поведение. Вам просто нужно их отправлять. Такая функция не кажется сложной!



> 短信发送类图

![短信发送组合模式版](https://raw.githubusercontent.com/blaywille1/dp/master/14.composite/img/composite-msg.jpg)

**
完整源码：[https://github.com/blaywille1/dp/blob/master/14.composite/source/composite-msg.php](https://github.com/blaywille1/dp/blob/master/14.composite/source/composite-msg.php)**

```php
<?php

abstract class Role
{
    protected $userRoleList;
    protected $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    abstract public function Add(Role $role);

    abstract public function Remove(Role $role);

    abstract public function SendMessage();
}

class RoleManger extends Role
{
    public function Add(Role $role)
    {
        $this->userRoleList[] = $role;
    }

    public function Remove(Role $role)
    {
        $position = 0;
        foreach ($this->userRoleList as $n) {
            ++$position;
            if ($n == $role) {
                array_splice($this->userRoleList, ($position), 1);
            }
        }
    }

    public function SendMessage()
    {
        echo "Начать рассылку ролей пользователей
：".$this->name.'Все текстовые сообщения пользователя в
', PHP_EOL;
        foreach ($this->userRoleList as $role) {
            $role->SendMessage();
        }
    }
}

class Team extends Role
{

    public function Add(Role $role)
    {
        echo "Пользователи группы больше не могут добавлять подчиненных
！", PHP_EOL;
    }

    public function Remove(Role $role)
    {
        echo "У пользователей группы нет подчиненных для удаления
！", PHP_EOL;
    }

    public function SendMessage()
    {
        echo "Роль пользователя группы
：".$this->name.'Смс отправлено
！', PHP_EOL;
    }
}

// root用户
$root = new RoleManger('Пользователи веб-сайта
');
$root->add(new Team('Пользователь главной станции
'));
$root->SendMessage();

// 社交版块
$root2 = new RoleManger('Социальный раздел
');
$managerA = new RoleManger('Пользователи форума
');
$managerA->add(new Team('Пользователи Пекинского форума
'));
$managerA->add(new Team('Пользователи форума в Шанхае
'));

$managerB = new RoleManger('sns пользователь
');
$managerB->add(new Team('Пользователь Beijing sns
'));
$managerB->add(new Team('Пользователь Shanghai sns
'));

$root2->add($managerA);
$root2->add($managerB);
$root2->SendMessage();

```

- Когда я хочу отправить пользователей в раздел форума, я могу свободно добавлять листовые узлы каждой локальной станции
  для управления отправляющим объектом.
- Вы можете рассматривать всю отправку $ root2 целиком, а различные разделы и регионы как части
- Эта комбинация может распространяться полностью вниз, пока не кончится глубина листового узла.Конечно, эта степень
  контролируется вами, что очень ясно.

## пример

```php
<?php

//Вот разные типы сотрудников:

interface Employee
{
    public function __construct(string $name, float $salary);
    public function getName(): string;
    public function setSalary(float $salary);
    public function getSalary(): float;
    public function getRoles(): array;
}

class Developer implements Employee
{
    protected $salary;
    protected $name;

    public function __construct(string $name, float $salary)
    {
        $this->name = $name;
        $this->salary = $salary;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setSalary(float $salary)
    {
        $this->salary = $salary;
    }

    public function getSalary(): float
    {
        return $this->salary;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}

class Designer implements Employee
{
    protected $salary;
    protected $name;

    public function __construct(string $name, float $salary)
    {
        $this->name = $name;
        $this->salary = $salary;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setSalary(float $salary)
    {
        $this->salary = $salary;
    }

    public function getSalary(): float
    {
        return $this->salary;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}

//А вот компания, которая состоит из сотрудников разных типов:

class Organization
{
    protected $employees;

    public function addEmployee(Employee $employee)
    {
        $this->employees[] = $employee;
    }

    public function getNetSalaries(): float
    {
        $netSalary = 0;

        foreach ($this->employees as $employee) {
            $netSalary += $employee->getSalary();
        }

        return $netSalary;
    }
}

//Использование:

// Подготовка сотрудников
$john = new Developer('John Doe', 12000);
$jane = new Designer('Jane Doe', 15000);

// Включение их в штат
$organization = new Organization();
$organization->addEmployee($john);
$organization->addEmployee($jane);

echo "Net salaries: " . $organization->getNetSalaries(); // Net Salaries: 27000

```
