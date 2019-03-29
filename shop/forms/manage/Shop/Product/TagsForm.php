<?php

namespace shop\forms\manage\Shop\Product;

use shop\entities\Shop\Product\Product;
use shop\entities\Shop\Tag;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class TagsForm extends Model
{

    public $tags = [];

    public function __construct(Product $product = null, array $config = [])
    {
        if ($product) {
            $this->tags = ArrayHelper::getColumn($product->tagAssignments, 'tag_id');
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['tags', 'default', 'value' => []],
        ];
    }

    public function tagList(): array
    {
        return ArrayHelper::map(Tag::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

}