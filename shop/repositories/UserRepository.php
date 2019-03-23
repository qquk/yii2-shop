<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 01.02.2018
 * Time: 00:08
 */

namespace shop\repositories;

use shop\dispatchers\EventDispatcher;
use shop\entities\User\User;

class UserRepository
{

    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function getByPasswordResetToken(string $token): User
    {
        return $this->getBy(['password_reset_token' => $token]);
    }

    public function getByEmail(string $email): User
    {
        return $this->getBy(['email' => $email]);
    }

    public function save(User $user): void
    {
        if (!$user->save(false)) {
            throw new \RuntimeException("Saving error..");
        }

        $this->dispatcher->dispatchAll($user->releaseEvents());
    }


    public function remove(User $user): void
    {
        if (!$user->delete()) {
            throw new \RuntimeException('Removing error.');
        }
        $this->dispatcher->dispatchAll($user->releaseEvents());
    }


    public function getByUserNameOrEmail($value)
    {
        return User::find()->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
    }

    public function getByEmailConfirmToken(string $token): User
    {
        return $this->getBy(['email_confirm_token' => $token]);
    }


    public function existsByPasswordResetToken(string $token): bool
    {
        return (bool)User::findByPasswordResetToken($token);
    }

    public function findByNetworkIdentity($network, $identity)
    {
        return User::find()->joinWith('network n')->andWhere(['identity' => $identity, 'network' => $network])->one();
    }

    public function get($id): User
    {
        if (!$user = User::findOne($id)) {
            throw new \DomainException("User not found");
        }
        return $user;
    }


    public function getBy(array $condition): User
    {
        if (!$user = User::find()->andWhere($condition)->limit(1)->one()) {
            throw new \DomainException("User not found");
        }
        return $user;
    }
}