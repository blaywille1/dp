<?php

interface Logger
{
    public function log(string $message);
}

interface LoggerFactory
{
    public function createLogger(): Logger;
}


class StdoutLogger implements Logger
{
    public function log(string $message)
    {
        echo $message;
    }
}


class FileLogger implements Logger
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function log(string $message)
    {
        file_put_contents($this->filePath, $message . PHP_EOL, FILE_APPEND);
    }
}


class StdoutLoggerFactory implements LoggerFactory
{
    public function createLogger(): Logger
    {
        return new StdoutLogger();
    }
}


class FileLoggerFactory implements LoggerFactory
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function createLogger(): Logger
    {
        return new FileLogger($this->filePath);
    }
}


// usage
$loggerFactory = new StdoutLoggerFactory();
$logger = $loggerFactory->createLogger();

$loggerFactory = new FileLoggerFactory(sys_get_temp_dir());
$logger = $loggerFactory->createLogger();
