<?php

namespace shop\forms\manage\Shop;

use shop\entities\Shop\Brand;
use shop\forms\CompositeForm;
use shop\validators\SlugValidator;

/**
 * Class BrandForm
 * @package shop\forms\Shop
 *
 *
 * @property MetaForm $meta
 */
class BrandForm extends CompositeForm
{

    public $name;

    public $slug;

    /**
     * @var Brand
     */
    private $_brand;

    public function __construct(Brand $brand = null, array $config = [])
    {
        if ($brand) {
            $this->name = $brand->name;
            $this->slug = $brand->slug;
            $this->meta = new MetaForm($brand->meta);
            $this->_brand = $brand;
        } else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
           [['name', 'slug'], 'required'],
           [['name', 'slug'], 'string', 'max' => 255],
           [['slug'], SlugValidator::class],
           [['name', 'slug'], 'unique', 'targetClass' => Brand::class ,'filter' => $this->_brand ? ['<>', 'id', $this->_brand->id] : []]
        ];
    }

    protected function internalForms(): array
    {
        return [
            'meta'
        ];
    }
}