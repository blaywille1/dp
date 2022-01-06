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
