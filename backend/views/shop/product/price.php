<?php
/* @var \shop\forms\manage\Shop\Product\ProductCreateForm $model */
?>
<div class="box box-default">
    <div class="box-header with-border"></div>
    <div class="box-body">
        <?= $form->field($model->price, 'new')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model->price, 'old')->textInput(['maxlength' => true]) ?>
    </div>
</div>