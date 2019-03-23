<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 27.09.2018
 * Time: 23:28
 */

namespace shop\services\Shop;


use shop\entities\Shop\Meta;
use shop\entities\Shop\Product;
use shop\forms\manage\Shop\Product\ProductCreateForm;
use shop\repositories\Shop\BrandRepository;
use shop\repositories\Shop\CategoryRepository;
use shop\repositories\Shop\ProductRepository;

class ProductMangeService
{
    private $brands;
    private $categories;
    private $products;

    public function __construct(ProductRepository $products, BrandRepository $brands, CategoryRepository $categories)
    {
        $this->brands = $brands;
        $this->categories = $categories;
        $this->products = $products;
    }

    public function create(ProductCreateForm $form): void
    {
        $brand = $this->brands->get($form->brandId);
        $category = $this->categories->get($form->categories->main);

        $product = Product::create(
            $brand->id,
            $category->id,
            $form->code,
            $form->name,
            new Meta(
                $form->meta->title,
                $form->meta->keywords,
                $form->meta->description

            )
        );

        $product->setPrice($form->price->old, $form->price->new);

        foreach ($form->categories->others as $other){
            $category = $this->categories->get($other);
            $product->assignCategory($category->id);
        }

        foreach ($form->values as $value){
            $product->setValue($value->id, $value->value);
        }

        $this->products->save($product);
    }

    public function remove($id): void
    {
        $product = $this->products->get($id);
        $this->products->remove($product);
    }
}