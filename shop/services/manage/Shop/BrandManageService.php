<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 08.09.2018
 * Time: 12:02
 */

namespace shop\services\Shop;


use shop\entities\Shop\Brand;
use shop\entities\Shop\Meta;
use shop\forms\Shop\BrandForm;
use shop\repositories\Shop\BrandRepository;

class BrandManageService
{

    private $brands;

    public function __construct(BrandRepository $brands)
    {
        $this->brands = $brands;
    }

    public function create(BrandForm $form)
    {
        $brand = Brand::create(
            $form->name,
            $form->slug,
            new Meta(
                $form->meta->title,
                $form->meta->keywords,
                $form->meta->description
            )
        );

        $this->brands->save($brand);

        return $brand;
    }

    public function edit($id, BrandForm $form)
    {
        $brand = $this->brands->get($id);
        $brand->edit(
            $form->name,
            $form->slug,
            new Meta(
                $form->meta->title,
                $form->meta->keywords,
                $form->meta->description
            )
        );
        $this->brands->save($brand);
    }

}