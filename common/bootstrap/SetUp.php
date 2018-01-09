<?php

namespace common\bootstrap;

use frontend\services\contact\ContactService;
use yii\base\BootstrapInterface;
use frontend\services\auth\PasswordResetService;
use yii\di\Instance;
use yii\mail\MailerInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;


        $container->setSingleton(MailerInterface::class, function () use ($app) {
            return $app->mailer;
        });

// так как в конструкторе только MailerInterfacce поэтому возюмет подхватит MailerInterface::class отсюда
//        $container->setSingleton(PasswordResetService::class, [], [Instance::of(MailerInterface::class)]);

        $container->setSingleton(ContactService::class, [], [$app->params['supportEmail'],  Instance::of(MailerInterface::class)]);


        //alternative
//        $container->setSingleton(ContactService::class, [], [$app->params['supportEmail']]);
        //alternative
//        $container->setSingleton(PasswordResetService::class, [] , [[$app->params['supportEmail'] => $app->name . ' robot']] );
    }
}