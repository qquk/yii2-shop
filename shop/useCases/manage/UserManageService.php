<?php

namespace shop\useCases\manage;

use shop\entities\User\User;
use shop\forms\manage\User\UserCreateForm;
use shop\forms\manage\User\UserEditForm;
use shop\repositories\UserRepository;
use shop\services\RoleManager;
use shop\services\TransactionManager;

class UserManageService
{
    private $users;
    private $transaction;
    private $roles;


    public function __construct(
        UserRepository $users,
        TransactionManager $transaction,
        RoleManager $roles
    )
    {
        $this->users = $users;
        $this->transaction = $transaction;
        $this->roles = $roles;
    }

    public function create(UserCreateForm $form): User
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->phone,
            $form->password
        );

        $this->transaction->wrap(function () use ($form, $user) {
            $this->users->save($user);
            $this->roles->assign($user->id, $form->role);
        });
        return $user;
    }

    public function edit($id, UserEditForm $form): void
    {
        $user = $this->users->get($id);
        $user->edit(
            $form->username,
            $form->email,
            $form->phone
        );

        $this->transaction->wrap(function () use ($form, $user) {
            $this->users->save($user);
            $this->roles->assign($user->id, $form->role);
        });
    }

    public function assignRole($id, $role): void
    {
        $user = $this->users->get($id);
        $this->roles->assign($user->id, $role);
    }


    public function remove($id): void
    {
        $user = $this->users->get($id);
        $this->users->remove($user);
    }

}