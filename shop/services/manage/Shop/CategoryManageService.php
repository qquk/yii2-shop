<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 08.09.2018
 * Time: 18:30
 */

namespace shop\services\Shop;


use shop\entities\Shop\Category;
use shop\entities\Shop\Meta;
use shop\forms\Shop\CategoryForm;
use shop\repositories\Shop\CategoryRepository;

class CategoryManageService
{

    private $categories;

    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    public function create(CategoryForm $form): Category
    {
        $parent = $this->categories->get($form->parentId);

        $category = Category::create(
            $form->name,
            $form->slug,
            $form->title,
            $form->description,
            new Meta(
                $form->meta->title,
                $form->meta->keywords,
                $form->meta->description
            )
        );

        $category->appendTo($parent);
        $this->categories->save($category);
        return $category;

    }

    public function edit($id, CategoryForm $form): void
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);

        $category->edit(
            $form->name,
            $form->slug,
            $form->title,
            $form->description,
            new Meta(
                $form->meta->title,
                $form->meta->keywords,
                $form->meta->description
            )
        );

        if($form->parentId !== $category->parent->id){
            $parent = $this->categories->get($form->parentId);
            $category->appendTo($parent);
        }

        $this->categories->save($category);

    }

    public function remove($id): void{
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        $this->categories->remove($category);
    }

    public function assertIsNotRoot(Category $category)
    {
        if($category->isRoot()){
            throw new \DomainException('Unable to manage root category');
        }
    }

}