<?php
/**
 * Created by PhpStorm.
 * User: QQUK
 * Date: 20.12.2017
 * Time: 23:06
 */

namespace frontend\services\auth;


use common\entities\User;
use frontend\forms\SignupForm;
use SebastianBergmann\GlobalState\RuntimeException;

class SignupService
{
    public function signup(SignupForm $form): User
    {
        $user = User::requestSignup($form->username, $form->email, $form->password);
        $this->save($user);
        return $user;
    }

    public function confirm($token){
        if(empty($token)){
            throw new \DomainException("Emty token");
        }

        $user = $this->findByEmailConfirmToken($token);

        $user->confirmSignup();

        $this->save($user);

    }

    private function findByEmailConfirmToken(string $token): User{
        $user = User::findOne(['email_confirm_token' => $token]);
        if(!$user){
            throw new \DomainException("User not found");
        }
        return $user;
    }

    private function save(User $user) : void{
        if(!$user->save()){
            throw new RuntimeException("Saving error");
        }
    }


}