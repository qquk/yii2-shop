<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07.09.2018
 * Time: 14:26
 */
namespace shop\forms\Shop;

use shop\entities\Shop\Tag;
use shop\validators\SlugValidator;
use yii\base\Model;

class TagForm extends Model
{

    public $name;
    public $slug;

    private $_tag;

    public function __construct(Tag $tag = null , array $config = [])
    {
        if($tag){
            $this->name = $tag->name;
            $this->slug = $tag->slug;
            $this->_tag = $tag;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            [['slug', 'name'], 'unique', 'targetClass' => Tag::class, 'filter' => $this->_tag ? ['<>', 'id', $this->_tag->id] : null]
        ];
    }

}