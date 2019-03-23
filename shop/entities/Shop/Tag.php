<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07.09.2018
 * Time: 13:38
 */

namespace shop\entities\Shop;


use yii\db\ActiveRecord;

/**
 * Class Tag
 * @package shop\entities\Shop
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 */
class Tag extends ActiveRecord
{

    public static function create($name, $slug) : self
    {
        $tag = new static();
        $tag->name = $name;
        $tag->slug = $slug;

        return $tag;
    }

    public function edit($name, $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
    }

    public static function tableName()
    {
        return '{{%shop_tags}}';
    }

}