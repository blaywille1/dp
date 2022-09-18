<?php

/**
 * This is the abstract factory, each factory should extend this
 * (WebOutputTypeFactory & DataOutputTypeFactory)
 */
abstract class AbstractOutputTypeFactory
{
    abstract public function prettyOutput();

    abstract public function uglyOutput();
}

/**
 * All class which represent pretty output, should extend this class
 */
abstract class AbstractPrettyOutput
{
    abstract public function getPrettyOutput();
}

/**
 * All class which represent ugly output, should extend this class
 */
abstract class AbstractUglyOutput
{
    abstract public function getUglyOutput();
}

/**
 * This is a factory which can create all types of web output objects
 */
class WebOutputTypeFactory extends AbstractOutputTypeFactory
{
    public function prettyOutput()
    {
        return new WebPrettyOutput();
    }

    public function uglyOutput()
    {
        return new WebUglyOutput();
    }
}

/**
 * This is a factory which can create all types of data output objects
 */
class DataOutputTypeFactory extends AbstractOutputTypeFactory
{
    public function prettyOutput()
    {
        return new DataPrettyOutput();
    }

    public function uglyOutput()
    {
        return new DataUglyOutput();
    }
}

/**
 * This class will represent pretty web output (e.g. HTML)
 */
class WebPrettyOutput extends AbstractPrettyOutput
{
    public function getPrettyOutput()
    {
        return '<h1>Imagine you had some really pretty web output here</h1>';
    }
}

/**
 * This class will represent ugly web output (e.g. XML)
 */
class WebUglyOutput extends AbstractUglyOutput
{
    public function getUglyOutput()
    {
        return 'Imagine you had some really ugly web output here';
    }
}

/**
 * This class will represent pretty data output (e.g. JSON)
 */
class DataPrettyOutput extends AbstractPrettyOutput
{
    public function getPrettyOutput()
    {
        return "{ 'text': 'Imagine you had some really pretty data output here' }";
    }
}

/**
 * This class will represent ugly data output(e.g. CSV)
 */
class DataUglyOutput extends AbstractUglyOutput
{
    public function getUglyOutput()
    {
        return 'Imagine, you, had, some, really, ugly, CSV, output, here';
    }
}

// this is used to create web outputs
$webFactory = new WebOutputTypeFactory();

$webPretty = $webFactory->prettyOutput();
echo $webPretty->getPrettyOutput(); //


// Imagine you had some really pretty web output here

$webUgly = $webFactory->uglyOutput();
echo $webUgly->getUglyOutput(); // Imagine you had some really ugly web output here

// this is used to create data outputs
$dataFactory = new DataOutputTypeFactory();

$dataPretty = $dataFactory->prettyOutput();
echo $dataPretty->getPrettyOutput(); // { 'text': 'Imagine you had some really pretty data output here' }

$dataUgly = $dataFactory->uglyOutput();
echo $dataUgly->getUglyOutput(); // Imagine, you, had, some, really, ugly, CSV, output, here


/*

The factory pattern is a powerful design pattern in all of its forms. Some people may tell you the simple factory shouldn’t be used, generally having poor reasons not to do so. At the end of the day we just want to get things done and unless you’re working with someone extremely anal, nobody should have a problem.

The abstract factory pattern is by far the hardest to understand out of the three. It’s not always obvious when a good time to use it would be. Don’t force this, there is a huge amount of abstraction in place which is only required when building complex systems. As long as you know what an abstract factory is, sooner or later you’ll find a genuine use case.

*/