<?php

namespace common\bootstrap;

use shop\dispatchers\DeferredEventDispatcher;
use shop\dispatchers\EventDispatcher;
use shop\dispatchers\SimpleEventDispatcher;
use shop\entities\User\events\SignupRequestedEvent;
use shop\entities\User\events\UserSignUpConfirmed;
use shop\listeners\User\SignupRequestedListener;
use shop\listeners\User\UserSignupConfirmedListener;
use shop\services\ContactService;
use yii\base\BootstrapInterface;
use yii\di\Container;
use yii\di\Instance;
use yii\mail\MailerInterface;
use yii\rbac\ManagerInterface;

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

        $container->setSingleton(ContactService::class, [], [$app->params['supportEmail'], Instance::of(MailerInterface::class)]);


        //alternative
//        $container->setSingleton(ContactService::class, [], [$app->params['supportEmail']]);
        //alternative
//        $container->setSingleton(PasswordResetService::class, [] , [[$app->params['supportEmail'] => $app->name . ' robot']] );

        $container->setSingleton(ManagerInterface::class, function () use ($app) {
            return $app->getAuthManager();
        });
        $container->setSingleton(EventDispatcher::class, DeferredEventDispatcher::class);

        $container->setSingleton(DeferredEventDispatcher::class,
            function (Container $container) {
                return new DeferredEventDispatcher(new SimpleEventDispatcher($container,
                    [
                        SignupRequestedEvent::class => [SignupRequestedListener::class],
                        UserSignUpConfirmed::class => [UserSignupConfirmedListener::class]
                    ]
                ));
            }
        );
    }
}