<?php

namespace shop\entities\Shop\Product;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use shop\entities\behaviors\MetaBehavior;
use shop\entities\Shop\Brand;
use shop\entities\Shop\Category;
use shop\entities\Shop\Meta;
use shop\entities\Shop\queries\ProductQuery;
use shop\entities\Shop\Tag;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Product
 * @package shop\entities\Shop
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $brand_id
 * @property integer $created_at
 * @property string $code
 * @property string $name
 * @property string $description
 * @property integer $weight
 * @property integer $status
 * @property integer $price_new
 * @property integer $price_old
 * @property integer $quantity
 *
 *
 * @property Meta $meta
 * @property Brand $brand
 * @property TagAssignments[] $tagAssignments;
 * @property CategoryAssignments[] $categoryAssignments;
 * @property Tag[] $tags;
 */
class Product extends ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;

    public $meta;

    public static function create($brandId, $category_id, $code, $name, $description, $weight, $quantity, Meta $meta): self
    {
        $product = new static();
        $product->brand_id = $brandId;
        $product->category_id = $category_id;
        $product->code = $code;
        $product->name = $name;
        $product->description = $description;
        $product->weight = $weight;
        $product->quantity = $quantity;
        $product->meta = $meta;
        $product->created_at = time();
        $product->status = self::STATUS_DRAFT;

        return $product;
    }

    public function setPrice($old, $new)
    {
        $this->price_old = $old;
        $this->price_new = $new;
    }

    public function assignTag($tag_id): void
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForTag($tag_id)) {
                return;
            }
        }
        $assignments[] = TagAssignments::create($tag_id);
        $this->tagAssignments = $assignments;
    }

    public function revokeTag($tag_id): void
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForTag($tag_id)) {
                unset($assignments[$i]);
                $this->tagAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException("Assignment not found");

    }

    public function revokeTags(): void
    {
        $this->tagAssignments = [];
    }

    public function assignCategory($category_id): void
    {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForCategoryId($category_id)) {
                return;
            }
        }
        $assignments[] = CategoryAssignments::create($category_id);
        $this->categoryAssignments = $assignments;

    }

    public function revokeCategory($category_id): void
    {
        $assignments = $this->categoryAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForCategoryId($category_id)) {
                unset($assignments[$i]);
                $this->categoryAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException("Assignment not found");
    }

    public function revokeCategories(): void
    {
        $this->categoryAssignments = [];
    }


    public function getBrand(): ActiveQuery
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }

    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagAssignments');
    }

    public function getTagAssignments(): ActiveQuery
    {
        return $this->hasMany(TagAssignments::class, ['product_id' => 'id']);
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getCategoryAssignments(): ActiveQuery
    {
        return $this->hasMany(CategoryAssignments::class, ['product_id' => 'id']);
    }


    public static function tableName()
    {
        return '{{%shop_products}}';
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['tagAssignments', 'categoryAssignments']
            ]
        ];
    }

    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

}