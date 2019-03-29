<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="create-product">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?php

    echo Tabs::widget(
        ['items' => [
            [
                'label' => "Common",
                'active' => true,
                'content' => $this->render('common', [
                    'model' => $model,
                    'form' => $form
                ])
            ],
            [
                'label' => "Price",
                'content' => $this->render('price', [
                    'model' => $model,
                    'form' => $form
                ])
            ],
            [
                'label' => 'Seo',
                'content' => $this->render('seo', [
                    'model' => $model,
                    'form' => $form
                ])
            ],
            [
                'label' => 'Warehouse',
                'content' => $this->render('warehouse', [
                    'model' => $model,
                    'form' => $form
                ])
            ]
        ]]
    );
    ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
