<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 26.12.2017
 * Time: 23:34
 */

namespace shop\services;


use shop\forms\ContactForm;
use SebastianBergmann\GlobalState\RuntimeException;
use yii\mail\MailerInterface;

class ContactService
{
    private $adminEmail;
    private $mailer;


    public function __construct($adminEmail, MailerInterface $mailer)
    {
        $this->adminEmail = $adminEmail;
        $this->mailer = $mailer;
    }

    public function send(ContactForm $form): void
    {
        $sent = $this->mailer->compose()
            ->setTo($this->adminEmail)
            ->setSubject($form->subject)
            ->setTextBody($form->body)
            ->send();

        if (!$sent) {
            throw new RuntimeException("Sending error");
        }
    }
}