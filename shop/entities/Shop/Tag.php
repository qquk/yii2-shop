<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.03.2019
 * Time: 15:37
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

    public static function create($name, $slug): Tag
    {
        $tag = new static();
        $tag->name = $name;
        $tag->slug = $slug;
        return $tag;
    }

    public function edit($name, $slug): void
    {
      $this->name = $name;
      $this->slug = $slug;
    }

    public static function tableName(): string
    {
        return '{{%shop_tags}}';
    }


}