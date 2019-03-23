<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 24.09.2018
 * Time: 22:35
 */

namespace shop\repositories\Shop;


use shop\entities\Shop\Characteristic;

class CharacteristicRepository
{
    use RepositoryTrait;

    public $modelClass = Characteristic::class;

}