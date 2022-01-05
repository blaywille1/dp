<?php

interface Observer
{
    public function update($obj);
}

class Message implements Observer
{
    //....

    function update($obj)
    {
        echo 'Отправить текстовое сообщение о новом заказе
('.$obj->mobile.')Уведомить продавца！';
    }

    //....
}

class Goods implements Observer
{
    //....

    public function update($obj)
    {
        echo 'Изменить продукт
'.$obj->goodsId.'Инвентарь！';
    }

    //....
}

class Order
{
    private $observers = [];

    public function attach($ob)
    {
        $this->observers[] = $ob;
    }

    public function detach($ob)
    {
        $position = 0;
        foreach ($this->observers as $ob) {
            if ($ob == $observer) {
                array_splice($this->observers, ($position), 1);
            }
            ++$position;
        }
    }

    public function sale()
    {
        // Товар продан
        // ....
        $obj = new stdClass();
        $obj->mobile = '13888888888';
        $obj->goodsId = 'Order11111111';
        $this->notify($obj);
    }

    public function notify($obj)
    {
        foreach ($this->observers as $ob) {
            $ob->update($obj);
        }
    }
}

$message = new Message();
$goods = new Goods();
$order = new Order();
$order->attach($message);
$order->attach($goods);

// Заказ продан! !
$order->sale();
