<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model shop\forms\manage\Shop\TagForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $tags shop\forms\manage\Shop\Product\TagsForm */
?>

<div class="tag-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo $form->field($tags, 'tags')->widget(\kartik\select2\Select2::classname(), [
        'data' => $tags->tagList(),
        'options' => ['placeholder' => 'Select a color ...', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ])->label('Tag Multiple');
    ?>

    <div class="box box-default">
        <div class="box-header with-border">Common</div>
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
