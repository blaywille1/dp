<?php

interface Builder
{
    public function BuildAttribute($attr);

    public function BuildButton($button);

    public function BuildTitle($title);

    public function BuildContent($content);

    public function GetDialog();
}

class Dialog
{
    private $attributes = [];
    private $buttons = [];
    private $title = '';
    private $content = '';

    public function AddAttributes($attr)
    {
        $this->attributes[] = $attr;
    }

    public function AddButtons($button)
    {
        $this->buttons[] = $button;
    }

    public function SetTitle($title)
    {
        $this->title = $title;
    }

    public function SetContent($content)
    {
        $this->content = $content;
    }

    public function ShowDialog()
    {
        echo PHP_EOL, 'Показать окно подсказки
 === ', PHP_EOL;
        echo 'заглавие：'.$this->title, PHP_EOL;
        echo 'содержание：'.$this->content, PHP_EOL;
        echo 'стиль：'.implode(',', $this->attributes), PHP_EOL;
        echo 'Кнопка：'.implode(',', $this->buttons), PHP_EOL;
    }
}

class DialogBuilder implements Builder
{
    private $dialog;

    public function __construct()
    {
        $this->dialog = new Dialog();
    }

    public function BuildAttribute($attr)
    {
        $this->dialog->AddAttributes($attr);
    }

    public function BuildButton($button)
    {
        $this->dialog->AddButtons($button);
    }

    public function BuildTitle($title)
    {
        $this->dialog->SetTitle($title);
    }

    public function BuildContent($content)
    {
        $this->dialog->SetContent($content);
    }

    public function GetDialog()
    {
        return $this->dialog;
    }
}

class DialogDirector
{
    public function Construct($title, $content)
    {

        $builder = new DialogBuilder();

        $builder->BuildAttribute('Положить сверху
');
        $builder->BuildAttribute('Центральный дисплей
');

        $builder->BuildButton('подтверждать');
        $builder->BuildButton('Отмена');

        $builder->BuildTitle($title);
        $builder->BuildContent($content);

        return $builder;
    }
}

class ModalDialogDirector
{
    public function Construct($title, $content)
    {

        $builder = new DialogBuilder();

        $builder->BuildAttribute('Положить сверху
');
        $builder->BuildAttribute('Центральный дисплей
');
        $builder->BuildAttribute('Фоновые снимки
');
        $builder->BuildAttribute('Внешне некликабельный
');

        $builder->BuildButton('подтверждать
');
        $builder->BuildButton('Отмена');

        $builder->BuildTitle($title);
        $builder->BuildContent($content);

        return $builder;
    }
}

$d1 = new DialogDirector();
$d1->Construct('Окно 1
', 'Вы уверены, что хотите выполнить операцию A?
')->GetDialog()->ShowDialog();

$d2 = new ModalDialogDirector();
$d2->Construct('Окно 2
', 'Вы уверены, что хотите выполнить операцию B.？')->GetDialog()->ShowDialog();
