<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use shop\entities\Shop\Tag;

$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
        <?= Html::a('Create tag', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $provider,
                'filterModel' => $searchForm,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'name',
                        'value' => function (Tag $tag) {
                            return Html::a(Html::encode($tag->name), ['view', 'id' => $tag->id]);
                        },
                        'format' => 'raw'
                    ],
                    'slug',
                    ['class' => ActionColumn::class],
                ]
            ]); ?>
        </div>
    </div>
</div>
