<?php

// Интерфейс шаблона SMS
interface MessageTemplate
{
    public function message();
}

// Предположим, что существует много шаблонов, реализующих вышеуказанный интерфейс шаблона SMS
// Ниже представлен шаблон реализации одного из отправленных купонов

class CouponMessageTemplate implements MessageTemplate
{
    public function message()
    {
        return 'Информация о купонах: Мы являемся продуктом Niu X номер один в стране,
                    и мы дадим вам десять купонов！';
    }
}

// Готовимся украсить устаревший шаблон смс выше
abstract class DecoratorMessageTemplate implements MessageTemplate
{
    public $template;

    public function __construct($template)
    {
        $this->template = $template;
    }
}

// Фильтруем слова, запрещенные новым законом о рекламе
class AdFilterDecoratorMessage extends DecoratorMessageTemplate
{
    public function message()
    {
        return str_replace(
            '№1 в стране',
            'Второй в стране',
            $this->template->message()
        );
    }
}

// Используйте новый словарь, автоматически созданный нашими коллегами
// из отдела больших данных, для фильтрации конфиденциальных слов.
// Этот фильтр не является обязательным для фильтрации контента,
// вы можете использовать его.
class SensitiveFilterDecoratorMessage extends DecoratorMessageTemplate
{
    public $bigDataFilterWords = ['Корова X'];
    public $bigDataReplaceWords = ['Легко использовать'];

    public function message()
    {
        return str_replace($this->bigDataFilterWords,
            $this->bigDataReplaceWords, $this->template->message());
    }
}

// Клиент, отправляющий интерфейс, должен использовать шаблон
// для отправки SMS
class Message
{
    public $msgType = 'old';

    public function send(MessageTemplate $mt)
    {
        // отправляем его
        if ($this->msgType == 'old') {
            echo 'Отправлено пользователям интрасети'.$mt->message().PHP_EOL;
        } else {
            if ($this->msgType == 'new') {
                echo 'Отправлено всем пользователям сети'.$mt->message()
                    .PHP_EOL;
            }
        }

    }
}

$template = new CouponMessageTemplate();
$message = new Message();

// Старая система, фильтровать не нужно, видны только внутренние пользователи
$message->send($template);

// Новая система выпущена для всей сети, и контент нужно фильтровать.
$message->msgType = 'new';
$template = new AdFilterDecoratorMessage($template);
$template = new SensitiveFilterDecoratorMessage($template);

// После фильтрации отправляем
$message->send($template);
