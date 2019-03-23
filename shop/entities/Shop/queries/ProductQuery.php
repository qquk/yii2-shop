<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 24.01.2019
 * Time: 23:58
 */

namespace shop\entities\Shop\queries;


use shop\entities\Shop\Product;
use yii\db\ActiveQuery;

class ProductQuery extends ActiveQuery
{

    public function active()
    {
        return $this->where(['status' => Product::STATUS_ACTIVE]);
    }

}