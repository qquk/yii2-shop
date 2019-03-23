<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 08.09.2018
 * Time: 12:05
 */

namespace shop\repositories\Shop;



use shop\repositories\NotFoundException;
use yii\db\ActiveRecord;

trait RepositoryTrait
{
    public $modelClass;

    public function save(ActiveRecord $model): void
    {
        if(!$model->save()){
            throw new \RuntimeException("Saving error");
        }
    }

    public function remove(ActiveRecord $model): void
    {
        if(!$model->delete()){
            throw new \RuntimeException("Removing error");
        }
    }

    public function get($id)
    {
        $model = call_user_func_array([$this->modelClass, 'findOne'], [$id]);
        if(!$model){
            throw new NotFoundException("Model not found");
        }
        return $model;
    }
}