<?php
namespace shop\forms\auth;

use Yii;
use yii\base\Model;
use shop\entities\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],

        ];
    }

}
