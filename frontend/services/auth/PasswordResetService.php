<?php
/**
 * Created by PhpStorm.
 * User: QQUK
 * Date: 20.12.2017
 * Time: 23:40
 */

namespace frontend\services\auth;


use common\entities\User;
use frontend\forms\PasswordResetRequestForm;
use frontend\forms\ResetPasswordForm;
use SebastianBergmann\GlobalState\RuntimeException;
use yii\mail\MailerInterface;

class PasswordResetService
{

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function request(PasswordResetRequestForm $form): void
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $form->email,
        ]);

        if (!$user) {
            throw new \DomainException("User not found");
        }


        $user->requestPasswordReset();


        if (!$user->save()) {
            throw new \RuntimeException("Saving error");
        }

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
        if (empty($token) && !is_string($token)) {
            throw new \DomainException("Invalid token");
        }
        if (!User::findByPasswordResetToken($token)) {
            throw  new \DomainException("Wrong password reset token");
        }
    }

    public function reset($token, ResetPasswordForm $form)
    {
        $user = User::findByPasswordResetToken($token);
        if (!$user) {
            throw new \DomainException("User not found");
        }

        $user->resetPassword($form->password);

        if (!$user->save()) {
            throw new \RuntimeException("Saving error..");
        }


    }

}