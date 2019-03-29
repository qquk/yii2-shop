<?php

namespace shop\entities\Shop;


use paulzi\nestedsets\NestedSetsBehavior;
use shop\entities\behaviors\MetaBehavior;
use shop\entities\Shop\queries\CategoryQuery;
use yii\db\ActiveRecord;

/**
 * Class Category
 * @package shop\entities\Shop
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $meta_jso
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property Meta $meta
 *
 *
 * @property Category $parent
 * @property Category[] $parents
 * @property Category[] $children
 * @property Category $prev
 * @property Category $next
 *
 * @mixin NestedSetsBehavior
 */
class Category extends ActiveRecord
{

    /**
     * @var Meta
     */
    public $meta;

    public static function create($name, $title, $slug, $description, Meta $meta)
    {
        $category  = new static();
        $category->name = $name;
        $category->title = $title;
        $category->slug = $slug;
        $category->description = $description;
        $category->meta = $meta;
        return $category;
    }

    public function edit($name, $title, $slug, $description, Meta $meta)
    {
        $this->name = $name;
        $this->title = $title;
        $this->slug = $slug;
        $this->description = $description;
        $this->meta = $meta;
    }
    public function behaviors()
    {
        return [
            MetaBehavior::class,
            NestedSetsBehavior::class
        ];
    }

    public function getSeoTitle()
    {
        return $this->meta->title ?: $this->getHeadingTitle();
    }

    public function getHeadingTitle()
    {
        return $this->title ?: $this->name;
    }

    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    public static function tableName()
    {
        return '{{%shop_categories}}';
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

}