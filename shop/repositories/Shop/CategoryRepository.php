<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 08.09.2018
 * Time: 18:25
 */

namespace shop\repositories\Shop;


use shop\entities\Shop\Category;

class CategoryRepository
{
    use RepositoryTrait;

    public $modelClass = Category::class;

}