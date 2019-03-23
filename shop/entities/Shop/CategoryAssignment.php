<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 27.09.2018
 * Time: 23:45
 */

namespace shop\entities\Shop;


use yii\db\ActiveRecord;

/**
 * Class CategoryAssignment
 * @package shop\entities\Shop
 *
 * @property integer $category_id
 * @property integer $product_id
 */
class CategoryAssignment extends ActiveRecord
{

    public static function create($categoryId): self
    {
        $new = new static();
        $new->category_id = $categoryId;
        return $new;
    }

    public function isForCategory($id): bool
    {
        return $this->category_id = $id;
    }

    public static function tableName()
    {
        return '{{%shop_category_assignments}}';
    }

}