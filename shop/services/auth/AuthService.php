<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 16.04.2018
 * Time: 22:35
 */

namespace shop\services\auth;


use shop\forms\auth\LoginForm;
use shop\repositories\UserRepository;

class AuthService
{

    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth(LoginForm $form){
        
        $user = $this->users->getByUserNameOrEmail($form->username);
       
        if(!$user || !$user->isActive() || !$user->validatePassword($form->password)){
            throw new \DomainException("Undefined user or password");
        }
        return $user;
    }
}