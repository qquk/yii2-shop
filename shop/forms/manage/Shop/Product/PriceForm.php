<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.09.2018
 * Time: 22:33
 */

namespace shop\forms\manage\Shop\Product;


use shop\entities\Shop\Product;
use yii\base\Model;

class PriceForm extends Model
{
    public $old;
    public $new;

    public function __construct(Product $product = null, array $config = [])
    {
        if($product) {
            $this->old = $product->old;
            $this->new = $product->new;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['new'], 'required'],
            [['old', 'new'], 'integer', 'min' => 0]
        ];
    }
}