<?php

interface MessageTemplate
{
    public function GetTemplate();
}

class LoginMessage implements MessageTemplate
{
    public function GetTemplate()
    {
        echo 'Ваш код подтверждения для входа - [AAA], пожалуйста, не сообщайте его другим [XXX компания]
！', PHP_EOL;
    }
}

class RegisterMessage implements MessageTemplate
{
    public function GetTemplate()
    {
        echo 'Ваш регистрационный код подтверждения [BBB], пожалуйста, не сообщайте его другим [XXX компания]
！', PHP_EOL;
    }
}

class FindPasswordMessage implements MessageTemplate
{
    public function GetTemplate()
    {
        echo 'Ваш код восстановления пароля [CCC], пожалуйста, не сообщайте его другим [XXX компания]
！', PHP_EOL;
    }
}

abstract class MessageService
{
    protected $template;

    public function SetTemplate($template)
    {
        $this->template = $template;
    }

    abstract public function Send();
}

class AliYunService extends MessageService
{
    public function Send()
    {
        echo 'Alibaba Cloud начинает отправлять SMS：';
        $this->template->GetTemplate();
    }
}

class JiGuangService extends MessageService
{
    public function Send()
    {
        echo 'Аврора начинает отправлять текстовые сообщения：';
        $this->template->GetTemplate();
    }
}

// Три шаблона SMS
$loginTemplate = new LoginMessage();
$registerTemplate = new RegisterMessage();
$findPwTemplate = new FindPasswordMessage();

// Два поставщика услуг SMS
$aliYun = new AliYunService();
$jg = new JiGuangService();

// Случайная комбинация
// Аврора отправь регистрационное СМС
$jg->SetTemplate($registerTemplate);
$jg->Send();

// Alibaba Cloud отправляет SMS для входа в систему
$aliYun->SetTemplate($loginTemplate);
$aliYun->Send();

// Alibaba Cloud отправляет SMS с паролем
$aliYun->SetTemplate($findPwTemplate);
$aliYun->Send();

// Аврора отправляет СМС для входа
$jg->SetTemplate($loginTemplate);
$jg->Send();

// ......

