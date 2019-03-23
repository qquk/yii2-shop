<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 28.09.2018
 * Time: 00:25
 */

namespace shop\entities\Shop;


use yii\db\ActiveRecord;

/**
 * Class Value
 * @package shop\entities\Shop
 *
 * @property integer $characteristic_id;
 * @property string $value;
 * @property integer $id;
 */
class Value extends ActiveRecord
{

    public static function create($characteristicId, $value): self
    {
        $obj = new static();
        $obj->characteristic_id = $characteristicId;
        $obj->value = $value;
        return $obj;
    }

    public static function blank($characteristicId): self
    {
        $obj = new static();
        $obj->characteristic_id = $characteristicId;
        return $obj;
    }

    public function isForCharacteristic($id): bool
    {
        return $this->characteristic_id = $id;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public static function tableName()
    {
        return '{{@shop_values}}';
    }

}