<?php

namespace shop\forms\manage\Shop\Product;


use yii\base\Model;
use yii\web\UploadedFile;

class PhotosForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $files;

    public function rules()
    {
        return [
            ['files', 'each', 'rule' => ['image']]
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->files = UploadedFile::getInstance($this, 'files');
            return true;
        }
        return false;
    }

}