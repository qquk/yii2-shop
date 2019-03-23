<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07.09.2018
 * Time: 14:20
 */
namespace shop\repositories\Shop;

use shop\entities\Shop\Tag;

class TagRepository
{

    use RepositoryTrait;

    public $modelClass = Tag::class;

}