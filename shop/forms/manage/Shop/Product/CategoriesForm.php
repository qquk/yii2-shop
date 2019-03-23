<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.09.2018
 * Time: 22:48
 */

namespace shop\forms\manage\Shop\Product;


use shop\entities\Shop\Product;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CategoriesForm extends Model
{
    public $main;

    public $others;

    public function __construct(Product $product = null, array $config = [])
    {
        if ($product) {
            $this->main = $product->category_id;
            $this->others = ArrayHelper::getColumn($product->categoryAssignments, 'category_id');
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['main'], 'required'],
            [['main'], 'integer'],
            [['others'], 'each', 'rule' => ['integer']]
        ];
    }

}