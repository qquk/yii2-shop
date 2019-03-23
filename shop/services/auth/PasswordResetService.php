<?php
/**
 * Created by PhpStorm.
 * User: QQUK
 * Date: 20.12.2017
 * Time: 23:40
 */

namespace shop\services\auth;


use shop\forms\auth\PasswordResetRequestForm;
use shop\forms\auth\ResetPasswordForm;
use shop\repositories\UserRepository;
use yii\mail\MailerInterface;

class PasswordResetService
{

    private $users;
    private $mailer;

    public function __construct(MailerInterface $mailer, UserRepository $users)
    {
        $this->users = $users;
        $this->mailer = $mailer;
    }

    public function request(PasswordResetRequestForm $form): void
    {

        $user = $this->users->getByEmail($form->email);
        if(!$user->isActive()){
            throw new \DomainException("User is not active");
        }
        $user->requestPasswordReset();
        $this->users->save($user);

        $send = $this->mailer
               ->compose(
                  ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                  ['user' => $user]
             )
            ->setTo($form->email)
            ->setSubject('Password reset for ' . \Yii::$app->name)
            ->send();

        if (!$send) {
            throw new \RuntimeException("Sending error");
        }
    }

    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Password reset token cannot be blank.');
        }
        if (!$this->users->existsByPasswordResetToken($token)) {
            throw new \DomainException('Wrong password reset token.');
        }
    }


    public function reset($token, ResetPasswordForm $form)
    {
        $user = $this->users->getByPasswordResetToken($token);
        $user->resetPassword($form->password);
        $this->users->save($user);
    }





}