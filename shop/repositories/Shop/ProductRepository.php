<?php

namespace shop\repositories\Shop;

use shop\repositories\NotFoundException;
use shop\entities\Shop\Product\Product;

class ProductRepository
{
    public function get($id): Product
    {
        if (!$brand = Product::findOne($id)) {
            throw new NotFoundException('Brand is not found.');
        }
        return $brand;
    }

    public function save(Product $product): void
    {
        if (!$product->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Product $product): void
    {
        if (!$product->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    public function existsByBrandId($brandId): bool
    {
        return Product::find()->where(['brand_id' => $brandId])->exists();
    }

    public function existsByMainCategoryId($categoryId)
    {
        return Product::find()->where(['category_id' => $categoryId])->exists();
    }
}