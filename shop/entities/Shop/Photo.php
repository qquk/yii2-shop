<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 21.10.2018
 * Time: 15:24
 */

namespace shop\entities\Shop;


use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class Photo
 * @package shop\entities\Shop
 *
 * @property integer $id
 * @property string $file
 * @property integer $sort;
 */
class Photo extends ActiveRecord
{

    public function __construct(UploadedFile $file)
    {
        $photo = new static();
        $photo->file = $file;
        return $photo;
    }

    public function setSort($sort) : void
    {
        $this->sort = $sort;
    }

    public function isEqualTo($id): bool
    {
        return $this->id = $id;
    }

    public static function tableName()
    {
        return "{{%shop_photos}}";
    }

}