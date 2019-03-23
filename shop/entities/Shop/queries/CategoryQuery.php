<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 08.09.2018
 * Time: 17:52
 */
namespace shop\entities\Shop\queries;
use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery
{
    use NestedSetsQueryTrait;

}