<?php

namespace shop\useCases\Manage\Shop;


use shop\entities\Shop\Meta;
use shop\entities\Shop\Product\Product;
use shop\entities\Shop\Tag;
use shop\forms\manage\Shop\Product\ProductCreateForm;
use shop\repositories\Shop\CategoryRepository;
use shop\repositories\Shop\ProductRepository;
use shop\repositories\Shop\TagRepository;
use shop\services\TransactionManager;

class ProductManageService
{
    private $products;
    private $tags;
    private $categories;
    private $transaction;

    public function __construct(ProductRepository $products, TagRepository $tags, CategoryRepository $categories, TransactionManager $transaction)
    {
        $this->products = $products;
        $this->tags = $tags;
        $this->categories = $categories;
        $this->transaction = $transaction;
    }

    public function create(ProductCreateForm $form): Product
    {

        $product = Product::create(
            $form->brandId,
            $form->categories->main,
            $form->code,
            $form->name,
            $form->description,
            $form->weight,
            $form->quantity->quantity,
            new Meta(
                $form->meta->title,
                $form->meta->keywords,
                $form->meta->description
            )
        );

        $product->setPrice($form->price->old, $form->price->new);

        foreach ($form->categories->others as $category_id) {
            $category = $this->categories->get($category_id);
            $product->assignCategory($category->id);
        }

        $this->transaction->wrap(function () use ($form, $product) {
            foreach ($form->tags->tags as $tagName) {
                if (!is_numeric($tagName)&& !$tag = $this->tags->findByName($tagName)) {
                    $tag = Tag::create($tagName, $tagName);
                    $this->tags->save($tag);
                } else {
                    $tag = $this->tags->get($tagName);
                }
                $product->assignTag($tag->id);
            }
            $this->products->save($product);
        });

        return $product;

    }

}