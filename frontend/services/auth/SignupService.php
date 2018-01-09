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
        $user = User::signup($form->username, $form->email, $form->password);
        if (!$user->save()) {
            throw new RuntimeException("Saving error");
        }
        return $user;
    }
}