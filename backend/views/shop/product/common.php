<?php

use mihaildev\ckeditor\CKEditor;
use \yii\helpers\Html;
use \kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model shop\forms\manage\Shop\Product\ProductCreateForm */
?>
<div class="box box-default">
    <div class="box-header with-border"></div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'brandId')->dropDownList($model->brandList()) ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border"></div>
                    <div class="box-body">
                        <?php
                        echo $form->field($model->categories, 'main')->widget(Select2::class, [
                            'data' => $model->categories->categoriesList(),
                            'options' => ['placeholder' => 'Select a main category ...'],
                            'pluginOptions' => [
                                'tags' => true,
                                'tokenSeparators' => [',', ' '],
                                'maximumInputLength' => 10
                            ],
                        ]);
                        echo  $form->field($model->categories, 'others')->widget(Select2::class, [
                            'data' => $model->categories->categoriesList(),
                            'options' => ['placeholder' => 'Select the categories ...', 'multiple' => true],
                            'pluginOptions' => [
                                'tags' => true,
                                'tokenSeparators' => [',', ' '],
                                'maximumInputLength' => 10
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-body">
                        <?php
                        echo $form->field($model->tags, 'tags')->widget(Select2::classname(), [
                            'data' => $model->tags->tagList(),
                            'options' => ['placeholder' => 'Select a tag ...', 'multiple' => true],
                            'pluginOptions' => [
                                'tags' => true,
                                'tokenSeparators' => [',', ' '],
                                'maximumInputLength' => 10
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?= $form->field($model, 'description')->widget(CKEditor::className()) ?>
    </div>

</div>

