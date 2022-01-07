<?php

//Реализуем вышеописанный пример с веб-страницами.
// Сделаем иерархию WebPage:


interface WebPage
{
    public function __construct(Theme $theme);

    public function getContent();
}

interface Theme
{
    public function getColor();
}

class About implements WebPage
{
    protected $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    public function getContent()
    {
        return "About page in ".$this->theme->getColor();
    }
}

//Отделим иерархию тем:

class Careers implements WebPage
{
    protected $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    public function getContent()
    {
        return "Careers page in ".$this->theme->getColor();
    }
}

class DarkTheme implements Theme
{
    public function getColor()
    {
        return 'Dark Black';
    }
}

class LightTheme implements Theme
{
    public function getColor()
    {
        return 'Off white';
    }
}

class AquaTheme implements Theme
{
    public function getColor()
    {
        return 'Light blue';
    }
}

//Обе иерархии:


$darkTheme = new DarkTheme();

$about = new About($darkTheme);
$careers = new Careers($darkTheme);

echo $about->getContent(); // "About page in Dark Black";
echo $careers->getContent(); // "Careers page in Dark Black";
