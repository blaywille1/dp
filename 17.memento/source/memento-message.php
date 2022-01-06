<?php

class Message
{
    private $content;
    private $to;
    private $state;
    private $time;

    public function __construct($to, $content)
    {
        $this->to = $to;
        $this->content = $content;
        $this->state = 'еще не отправлено';
        $this->time = time();
    }

    public function Show()
    {
        echo $this->to, '---', $this->content, '---', $this->time, '---', $this->state, PHP_EOL;
    }

    public function CreateSaveSate()
    {
        $ss = new SaveState();
        $ss->SetState($this->state);

        return $ss;
    }

    public function SetSaveState($ss)
    {
        if ($this->state != $ss->GetState()) {
            $this->time = time();
        }
        $this->state = $ss->GetState();
    }

    public function SetState($state)
    {
        $this->state = $state;
    }

    public function GetState()
    {
        return $this->state;
    }

}

class SaveState
{
    private $state;

    public function SetState($state)
    {
        $this->state = $state;
    }

    public function GetState()
    {
        return $this->state;
    }
}

class StateContainer
{
    private $ss;

    public function SetSaveState($ss)
    {
        $this->ss = $ss;
    }

    public function GetSaveState()
    {
        return $this->ss;
    }
}

// Имитировать отправку SMS
$mList = [];
$scList = [];
for ($i = 0; $i < 10; $i++) {
    $m = new Message('Телефонный номер'.$i, 'содержание'.$i);
    echo 'Начальное состояние：';
    $m->Show();

    // Сохраните исходную информацию
    $sc = new StateContainer();
    $sc->SetSaveState($m->CreateSaveSate());
    $scList[] = $sc;

    // Имитация отправки SMS, 2 отправлены успешно, 3 отправлены не удалось
    $pushState = mt_rand(2, 3);
    $m->SetState($pushState == 2 ? 'Успешно отправлено
' : 'Не удалось отправить
');
    echo 'Статус после релиза：';
    $m->Show();

    $mList[] = $m;
}

// Смоделируйте другой поток, чтобы найти неудавшуюся отправку
// и восстановить их в неотправленное состояние
sleep(2);
foreach ($mList as $k => $m) {
    if ($m->GetState()
        == 'Не удалось отправить'
    ) { // Если не удалось отправить, восстановить статус
        $m->SetSaveState($scList[$k]->GetSaveState());
    }
    echo 'Запросить статус после сбоя публикации：';
    $m->Show();
}
