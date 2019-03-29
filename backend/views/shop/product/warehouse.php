<?php
/* @var $model \shop\forms\manage\Shop\Product\ProductCreateForm */
?>

<div class="box box-default">
    <div class="box-header with-border"></div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model->quantity, 'quantity')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
</div>
