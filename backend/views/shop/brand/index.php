<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use shop\entities\Shop\Brand;

$this->title = 'Brands';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
        <?= Html::a('Create brand', ['create'], ['class' => 'btn btn-primary']) ?>
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
                        'value' => function (Brand $brand) {
                            return Html::a(Html::encode($brand->name), ['view', 'id' => $brand->id]);
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
