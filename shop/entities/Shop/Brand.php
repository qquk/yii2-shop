<?php

namespace shop\entities\Shop;

use shop\entities\behaviors\MetaBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * Class Brand
 * @package shop\entities\Shop
 *
 * @property integer $id
 * @property string $name;
 * @property string $slug
 * @property Meta $meta
 */
class Brand extends ActiveRecord
{
    /**
     * @var Meta
     */
    public $meta;

    public static function create(string $name, string $slug, Meta $meta): Brand
    {
        $brand = new static();
        $brand->name = $name;
        $brand->slug = $slug;
        $brand->meta = $meta;
        return $brand;
    }

    public function edit(string $name, string $slug, Meta $meta): void
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->meta = $meta;
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class
        ];
    }

    public static function tableName(): string
    {
        return '{{%shop_brands}}';
    }

}