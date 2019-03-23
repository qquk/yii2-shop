<?php
/**
 * Created by PhpStorm.
 * User: QQUK
 * Date: 20.12.2017
 * Time: 23:06
 */

namespace shop\services\auth;


use shop\access\Rbac;
use shop\dispatchers\EventDispatcher;
use shop\entities\User\User;
use shop\forms\auth\SignupForm;
use shop\repositories\UserRepository;
use shop\services\RoleManager;
use shop\services\TransactionManager;

class SignupService
{

    private $users;
    private $dispatcher;
    private $transaction;
    private $roles;

    public function __construct(UserRepository $users, EventDispatcher $dispatcher, TransactionManager $transaction, RoleManager $roles)
    {
        $this->users = $users;
        $this->dispatcher = $dispatcher;
        $this->transaction = $transaction;
        $this->roles = $roles;
    }

    public function signup(SignupForm $form): User
    {
        $user = User::requestSignup($form->username, $form->email, $form->password);

        $this->transaction->wrap(function () use ($user) {
            $this->users->save($user);
            $this->roles->assign($user->id, Rbac::ROLE_USER);
        });


        return $user;
    }

    public function confirm($token)
    {
        if (empty($token)) {
            throw new \DomainException("Emty token");
        }

        $user = $this->users->getByEmailConfirmToken($token);
        $user->confirmSignup();
        $this->users->save($user);

    }
}