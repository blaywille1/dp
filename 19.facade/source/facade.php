<?php


/*
Об определении четырех и более подсистем и говорить нечего,
можно представить, что подсистем много, и они не обязательно такие же,
как эти четыре подсистемы, но могут быть очень разными.
*/

class Facade
{

    private $subStytemOne;
    private $subStytemTwo;
    private $subStytemThree;
    private $subStytemFour;

    public function __construct()
    {
        $this->subSystemOne = new SubSystemOne();
        $this->subSystemTwo = new SubSystemTwo();
        $this->subSystemThree = new SubSystemThree();
        $this->subSystemFour = new SubSystemFour();
    }

    public function MethodA()
    {
        $this->subSystemOne->MethodOne();
        $this->subSystemTwo->MethodTwo();
    }

    public function MethodB()
    {
        $this->subSystemOne->MethodOne();
        $this->subSystemTwo->MethodTwo();
        $this->subSystemThree->MethodThree();
        $this->subSystemFour->MethodFour();
    }
}

class SubSystemOne
{
    public function MethodOne()
    {
        echo 'Подсистема Метод первый
', PHP_EOL;
    }
}

class SubSystemTwo
{
    public function MethodTwo()
    {
        echo 'Подсистема, метод второй
', PHP_EOL;
    }
}

class SubSystemThree
{
    public function MethodThree()
    {
        echo 'Подсистема, метод третий
', PHP_EOL;
    }
}

class SubSystemFour
{
    public function MethodFour()
    {
        echo 'Подсистема, метод четвертый
', PHP_EOL;
    }
}

// Эти подсистемы упакованы классом фасада, и только
// вновь определенные методы фасада предоставляются внешнему миру.
$facade = new Facade();
$facade->MethodA();
$facade->MethodB();
