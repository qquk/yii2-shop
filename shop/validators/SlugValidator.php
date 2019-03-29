<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07.09.2018
 * Time: 17:51
 */
namespace shop\validators;

use yii\validators\RegularExpressionValidator;

class SlugValidator extends RegularExpressionValidator
{
    public $pattern = '#^[a-z0-9_-]+$#s';

}