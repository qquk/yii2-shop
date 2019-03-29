<?php

namespace shop\forms\manage\Shop\Product;


use shop\entities\Shop\Product\Product;
use yii\base\Model;

class PriceForm extends Model
{

    public $old;
    public $new;

    public function __construct(Product $product = null, array $config = [])
    {
        if ($product) {
            $this->old = $product->price_old;
            $this->new = $product->price_new;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['new'], 'required'],
            [['new', 'old'], 'integer', 'min' => 0],
        ];
    }

}