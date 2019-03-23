<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 08.09.2018
 * Time: 18:06
 */

namespace shop\forms\Shop;


use shop\entities\Shop\Category;
use shop\entities\Shop\Meta;
use shop\forms\CompositeForm;
use shop\validators\SlugValidator;

/**
 * Class Category
 * @package shop\forms\Shop
 *
 * @property MetaForm $meta;
 */
class CategoryForm extends CompositeForm
{

    public $name;
    public $slug;
    public $title;
    public $description;
    public $parentId;

    private $_category;

    public function __construct(Category $category, array $config = [])
    {
        if($category){
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->title = $category->title;
            $this->description = $category->description;
            $this->parentId = $category->parent ? $category->parent->id : null;
            $this->meta = new MetaForm($category->meta);

            $this->_category = $category;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            ['parentId', 'integer'],
            [['name', 'title', 'slug'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['slug'], SlugValidator::className()],
            [['name', 'slug'],'unique', 'targetClass' => Category::className(), 'filter' => $this->_category ? ['<>', 'id', $this->_category->id ] : null]
        ];
    }

    protected function internalForms(): array
    {
        return ['meta'];
    }
}