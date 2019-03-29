<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.09.2018
 * Time: 23:23
 */

namespace shop\forms\manage\Shop\Product;


use shop\entities\Shop\Brand;
use shop\entities\Shop\Product\Product;
use shop\forms\CompositeForm;
use shop\forms\manage\Shop\MetaForm;
use yii\helpers\ArrayHelper;

/**
 * Class ProductCreateForm
 * @package shop\forms\manage\Shop\Product
 *
 * @property TagsForm $tags
 * @property MetaForm $meta
 * @property PriceForm $price
 * @property QuantityForm $quantity
 * @property CategoriesForm $categories
 *
 */
class ProductCreateForm extends CompositeForm
{

    public $brandId;
    public $code;
    public $name;
    public $description;
    public $weight;

    public function __construct(array $config = [])
    {
        $this->tags = new TagsForm();
        $this->meta = new MetaForm();
        $this->price = new PriceForm();
        $this->quantity = new QuantityForm();
        $this->categories = new CategoriesForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return[
            [['brandId', 'code', 'name', 'weight'], 'required'],
            [['code', 'name'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['brandId'], 'integer'],
            [['code'], 'unique', 'targetClass' => Product::class],
            ['weight', 'integer', 'min' => 0]

        ];
    }

    protected function internalForms(): array
    {
        return ['meta', 'tags', 'price', 'quantity', 'categories'];
    }

    public function brandList()
    {
        return ArrayHelper::map(Brand::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }
}