<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 24.09.2018
 * Time: 22:10
 */

namespace shop\entities\Shop;


use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Characteristic
 * @package shop\entities\Shop
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property string $required
 * @property string $default
 * @property array $variants
 * @property integer $sort
 */
class Characteristic extends ActiveRecord
{
    const TYPE_STRING = 'string';
    const TYPE_INTEGER = 'integer';
    const TYPE_FLOAT = 'float';

    public $variants;

    public static function create($name, $type, $required, $default, array $variants, $sort): self
    {
        $new = new static();
        $new->name = $name;
        $new->type = $type;
        $new->required = $required;
        $new->default = $default;
        $new->variants = $variants;
        $new->sort = $sort;
        return $new;
    }

    public function edit($name, $type, $required, $default, array $variants, $sort): void
    {
        $this->name = $name;
        $this->type = $type;
        $this->required = $required;
        $this->default = $default;
        $this->variants = $variants;
        $this->sort = $sort;
    }

    public function isSelect(): bool
    {
        return count($this->variants) > 0;
    }

    public function afterFind()
    {
        $this->variants = Json::decode($this->getAttribute('variants_json'));
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('variants_json', Json::encode($this->variants));
        return parent::beforeSave($insert);
    }

    public function isString()
    {
        return $this->type === self::TYPE_STRING;
    }

    public function isInteger()
    {
        return $this->type === self::TYPE_INTEGER;
    }

    public function isFloat()
    {
        return $this->type === self::TYPE_FLOAT;
    }

    public static function tableName()
    {
        return '{{%shop_characteristics}}';
    }
}