<?php

namespace shop\forms\manage\Shop;

use shop\entities\Shop\Meta;
use yii\base\Model;

class MetaForm extends Model
{

    public $title;

    public $keywords;

    public $description;

    public function __construct(Meta $meta = null, $config = [])
    {
        if ($meta) {
            $this->title = $meta->getTitle();
            $this->keywords = $meta->getKeywords();
            $this->description = $meta->getDescription();
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
          [['title'], 'string', 'max' => 255],
          [['description', 'keywords'], 'string'],
        ];
    }

}