<?php

namespace shop\forms\manage\Shop;

use function foo\func;
use shop\entities\Shop\Category;
use shop\forms\CompositeForm;
use shop\validators\SlugValidator;
use yii\helpers\ArrayHelper;

/**
 * Class CategoryForm
 * @package shop\forms\manage\Shop
 *
 * @property MetaForm $meta
 */
class CategoryForm extends CompositeForm
{
    public $parentId;

    public $name;
    public $title;
    public $slug;
    public $description;

    private $_category;

    public function __construct(Category $category = null, array $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->title = $category->title;
            $this->slug = $category->slug;
            $this->description = $category->description;
            $this->meta = new MetaForm($category->meta);
            $this->_category = $category;
        } else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'slug', 'parentId'], 'required'],
            [['name', 'slug', 'title'], 'string', 'max' => 255],
            [['slug'], SlugValidator::class],
            [['parentId'], 'integer'],
            [['name', 'slug'], 'unique', 'targetClass' => Category::class, 'filter' => $this->_category ? ['<>', 'id', $this->_category->id] : null],

        ]; // TODO: Change the autogenerated stub
    }

    protected function internalForms(): array
    {
        return ['meta'];
    }

    public function parentCategoriesList(): array
    {
        return ArrayHelper::map(Category::find()->orderBy('lft')->asArray()->all(), 'id', function ($category) {
            return ($category['depth'] > 1 ? str_repeat('--', $category['depth'] - 1) . " " : "" ) . $category['name'];
        });
    }
}