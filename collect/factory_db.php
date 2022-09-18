<?php

class MySQLDB
{
    public function setHost($host)
    {
        // code
    }
    public function setDB($db)
    {
        // code
    }
    public function setUserName($user)
    {
        // code
    }
    public function setPassword($pwd)
    {
        // code
    }
    public function connect()
    {
        // code
    }
}

class PostgreSQLDB
{
    public function setHost($host)
    {
        // code
    }
    public function setDB($db)
    {
        // code
    }
    public function setUserName($user)
    {
        // code
    }
    public function setPassword($pwd)
    {
        // code
    }
    public function connect()
    {
        // code
    }
}


class DBFactory
{
    protected $driver = null;

    public function setDriver($driver)
    {
        $this->driver = $driver;
    }

    public function makeDB($host, $user, $pass, $dbname)
    {
        if ($this->driver === 'mysql') {
            $DB = new MySQLDB();
        }
        elseif ($this->driver === 'postgre') {
            $DB = new PostgreSQLDB();
        }
        elseif ($this->driver === 'sqlite') {
            $DB = new SQLiteDB();
        }

        $DB->setHost($host);
        $DB->setDB($dbname);
        $DB->setUserName($user);
        $DB->setPassword($pass);
        $DB->connect();

        return $DB;
    }
}

// usage
$dbFactory = new DBFactory;
$dbFactory->setDriver('mysql');
$DB = $dbFactory->makeDB("host", "db", "user", "pwd");
