<?php

namespace shop\entities\Shop\Product;

use yii\db\ActiveRecord;

/**
 * Class CategoryAssignments
 * @package shop\entities\Shop\Product
 *
 * @property integer $product_id
 * @property integer $category_id
 */
class CategoryAssignments extends ActiveRecord
{

    public static function create($category_id): self
    {
        $new = new static();
        $new->category_id = $category_id;
        return $new;
    }

    public function isForCategoryId($category_id): bool
    {
        return $this->category_id == $category_id;
    }

    public static function tableName(): string
    {
        return "{{%shop_category_assignments}}";
    }
}