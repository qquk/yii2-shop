<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.09.2018
 * Time: 22:40
 */

namespace shop\forms\manage\Shop\Product;


use shop\entities\Shop\Product;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class TagsForm extends Model
{
    public $existing;
    public $textNew;

    public function __construct(Product $product = null, array $config = [])
    {
        if ($product) {
            $this->existing = ArrayHelper::getValue($product->tagAssignments, 'tag_id');
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['existing'], 'each', 'rule' => ['integer']],
            [['textNew'], 'string']
        ];
    }

    public function getNewNames()
    {
        return array_map('trim', preg_split('#\s*,\s*#i', $this->textNew));
    }

}