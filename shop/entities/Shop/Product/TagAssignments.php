<?php

namespace shop\entities\Shop\Product;
use shop\entities\Shop\Tag;
use yii\db\ActiveRecord;

/**
 * Class TagAssignments
 * @package shop\entities\Shop\Product
 *
 * @property integer $product_id
 * @property integer $tag_id
 */
class TagAssignments extends ActiveRecord
{

    public static function create($tag_id): self
    {
        $new = new static();
        $new->tag_id = $tag_id;
        return $new;
    }

    public function isForTag($tag_id): bool
    {
        return $this->tag_id = $tag_id;
    }

    public static function tableName()
    {
        return '{{%shop_tag_assignments}}';
    }

}