<?php

abstract class Cache
{
    protected $config;
    protected $conn;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->GetConfig();
        $this->OpenConnection();
        $this->CheckConnection();
    }

    abstract public function GetConfig();

    abstract public function OpenConnection();

    abstract public function CheckConnection();
}

class MemcachedCache extends Cache
{
    public function GetConfig()
    {
        echo 'Получить файл конфигурации Memcached
！', PHP_EOL;
        $this->config = 'memcached';
    }

    public function OpenConnection()
    {
        echo 'Ссылка на memcached
!', PHP_EOL;
        $this->conn = 1;
    }

    public function CheckConnection()
    {
        if ($this->conn) {
            echo 'Memcached успешно подключен
！', PHP_EOL;
        } else {
            echo 'Ошибка подключения Memcached, проверьте элементы конфигурации
！', PHP_EOL;
        }
    }
}

class RedisCache extends Cache
{
    public function GetConfig()
    {
        echo 'Получить файл конфигурации Redis
！', PHP_EOL;
        $this->config = 'redis';
    }

    public function OpenConnection()
    {
        echo 'Ссылка redis
!', PHP_EOL;
        $this->conn = 0;
    }

    public function CheckConnection()
    {
        if ($this->conn) {
            echo 'Redis-соединение успешно
！', PHP_EOL;
        } else {
            echo 'Ошибка подключения Redis, проверьте элементы конфигурации
！', PHP_EOL;
        }
    }
}

$m = new MemcachedCache();

$r = new RedisCache();
