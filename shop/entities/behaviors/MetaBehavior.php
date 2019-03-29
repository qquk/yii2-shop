<?php

namespace shop\entities\behaviors;

use shop\entities\Shop\Meta;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class MetaBehavior extends Behavior
{

    public $metaProperty = 'meta';

    public $jsonMeta = 'meta_json';

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'onAfterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave'
        ];
    }

    public function onAfterFind(Event $e)
    {
        $model = $e->sender;
        $meta = Json::decode($model->{$this->jsonMeta});

        $model->{$this->metaProperty} = new Meta(
            ArrayHelper::getValue($meta, 'title'),
            ArrayHelper::getValue($meta, 'keywords'),
            ArrayHelper::getValue($meta, 'description')
        );
    }

    public function onBeforeSave(Event $event)
    {
        /** @var ActiveRecord $model */
        $model = $event->sender;
        /** @var Meta $meta */
        $meta = $model->{$this->metaProperty};

        $model->setAttribute($this->jsonMeta, Json::encode(
            [
                'title' => $meta->getTitle(),
                'keywords' => $meta->getKeywords(),
                'description' => $meta->getDescription()
            ]
        ));

    }

}