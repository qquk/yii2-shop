<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 27.09.2018
 * Time: 23:07
 */

namespace shop\entities\Shop;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use shop\entities\behaviors\MetaBehavior;
use shop\entities\Shop\queries\ProductQuery;
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
 * @property integer $price_old
 * @property integer $price_new
 * @property integer $rating
 * @property string $code
 * @property string $name
 *
 *
 *@property Meta $meta
 *@property Brand $brand
 *@property Category $category
 *@property CategoryAssignment[] $categoryAssignments
 *@property Value[] $values;
 *@property Photo[] $photos
 */
class Product extends ActiveRecord
{

    const STATUS_ACTIVE = 1;

    public $meta;


    public static function create($brandId, $categoryId, $code, $name, Meta $meta): self
    {
        $product = new static();
        $product->brand_id = $brandId;
        $product->category_id = $categoryId;
        $product->code = $code;
        $product->name = $name;
        $product->meta = $meta;

        return $product;
    }

    public function setPrice($old, $new): void
    {
        $this->price_old = $old;
        $this->price_new = $new;
    }

    public function changeMainCategory($categoryId): void
    {
        $this->category_id = $categoryId;
    }

    public function assignCategory($id): void
    {
        $assignments = $this->categoryAssignments;

        foreach ($assignments as $assignment){
            if($assignment->isForCategory($id)){
                return;
            }
        }
        $assignments[] = CategoryAssignment::create($id);
        $this->categoryAssignments = $assignments;
    }

    public function revokeCategory($id): void
    {
        $assignments = $this->categoryAssignments;

        foreach ($assignments as $i => $assignment){
            if($assignment->isForCategory($id)){
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

    public function setValue($id, $value): void
    {
        $values = $this->values;
        foreach ($values as $val){
            if($val->isForCharacteristic($id)){
                $val->setValue($value);
                return;
            }
        }
        $values[] = Value::create($id, $value);
        $this->values = $values;
    }

    public function getValue($id): Value
    {
        $values = $this->values;
        foreach ($values as $val){
            if($val->isForCharacteristic($id)){
                return $val;
            }
        }
        return Value::blank($id);
    }

    /**
     * @param Photo[] $photos
     */
    public function setPhotos(array $photos): void
    {
        foreach ($photos as $i => $photo){
            $photo->setSort($i);
        }
        $this->photos = $photos;
    }


    public function getBrand(): ActiveQuery
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    public function getValues(): ActiveQuery
    {
        $this->hasMany(Value::class, ['product_id' => 'id']);
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getCategoryAssignments(): ActiveQuery
    {
        return $this->hasMany(CategoryAssignment::class, ['product_id' => 'id']);
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::className(), ['product_id' => 'id']);
    }

    public static function tableName()
    {
        return '{{%shop_products}}';
    }

    public function behaviors()
    {
        return [
            MetaBehavior::className(),
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['categoryAssignments', 'values']
            ]
        ];
    }

    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

}