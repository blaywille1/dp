<?php

class HttpService
{
    private static $instance;

    public function GetInstance()
    {
        if (self::$instance == null) {
            self::$instance = new HttpService();
        }

        return self::$instance;
    }

    public function Post()
    {
        echo 'Отправить post на публикацию
', PHP_EOL;
    }

    public function Get()
    {
        echo 'Отправить get на получение
', PHP_EOL;
    }
}

$httpA = new HttpService();
$httpA->Post();
$httpA->Get();

$httpB = new HttpService();
$httpB->Post();
$httpB->Get();

var_dump($httpA == $httpB);

