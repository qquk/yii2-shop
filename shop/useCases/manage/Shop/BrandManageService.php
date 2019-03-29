<?php

namespace shop\useCases\Manage\Shop;

use shop\entities\Shop\Brand;
use shop\entities\Shop\Meta;
use shop\forms\manage\Shop\BrandForm;
use shop\repositories\Shop\BrandRepository;
use shop\repositories\Shop\ProductRepository;

class BrandManageService
{
    /**
     * @var BrandRepository
     */
    private $brands;

    /**
     * @var ProductRepository
     */
    private $products;

    public function __construct(BrandRepository $brands, ProductRepository $products)
    {
        $this->brands = $brands;
        $this->products = $products;
    }

    public function create(BrandForm $form): Brand
    {

        $brand = Brand::create(
            $form->name,
            $form->slug,
            new Meta($form->meta->title, $form->meta->keywords, $form->meta->description)
        );
        $this->brands->save($brand);
        return $brand;
    }

    public function edit($id, BrandForm $form): void
    {
        $brand = $this->brands->get($id);

        $brand->edit(
            $form->name,
            $form->slug,
            new Meta($form->meta->title, $form->meta->keywords, $form->meta->description)
        );

        $this->brands->save($brand);
    }

    public function remove($id)
    {
        $brand = $this->brands->get($id);
        if ($this->products->existsByBrandId($brand->id)) {
            throw new \DomainException('Unable to remove brand with products.');
        }
        $this->brands->remove($brand);
    }

}