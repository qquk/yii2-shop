<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.09.2018
 * Time: 23:23
 */

namespace shop\forms\manage\Shop\Product;


use shop\entities\Shop\Characteristic;
use shop\entities\Shop\Product;
use shop\forms\CompositeForm;
use shop\forms\Shop\MetaForm;

/**
 * Class ProductCreateForm
 * @package shop\forms\manage\Shop\Product
 *
 * @property PriceForm $price
 * @property CategoriesForm $categories
 * @property TagsForm $tags
 * @property PhotosForm $photos
 * @property MetaForm $meta
 * @property ValueForm[] $values
 *
 */
class ProductCreateForm extends CompositeForm
{

    public $brandId;
    public $code;
    public $name;

    public function __construct(array $config = [])
    {
        $this->price = new PriceForm();
        $this->categories = new CategoriesForm();
        $this->tags = new TagsForm();
        $this->photos = new PhotosForm();
        $this->values = array_map(function($characteristic){
            return new ValueForm($characteristic);
        }, Characteristic::find()->orderBy('sort')->all());

        parent::__construct($config);
    }

    public function rules()
    {
        return[
            [['brand_id', 'code', 'name'], 'required'],
            [['code', 'name'], 'string', 'max' => 255],
            [['brand_id'], 'integer'],
            [['code'], 'unique', 'targetClass' => Product::class],

        ];
    }

    protected function internalForms(): array
    {
        return ['price', 'meta', 'categories', 'tags', 'photos', 'values'];
    }
}