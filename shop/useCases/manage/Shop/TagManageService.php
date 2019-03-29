<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.03.2019
 * Time: 16:00
 */

namespace shop\useCases\Manage\Shop;


use shop\entities\Shop\Tag;
use shop\forms\manage\Shop\TagForm;
use shop\repositories\Shop\TagRepository;

class TagManageService
{
    private $tags;

    public function __construct(TagRepository $tags)
    {
        $this->tags = $tags;
    }

    public function crete(TagForm $form): Tag
    {
        $tag = Tag::create($form->name, $form->slug);
        $this->tags->save($tag);
        return $tag;
    }

    public function edit($id, TagForm $form): void
    {
        $tag = $this->tags->get($id);
        $tag->edit($form->name, $form->slug);
        $this->tags->save($tag);
    }

    public function remove($id) : void
    {
        $tag = $this->tags->get($id);
        $this->tags->remove($tag);
    }


}