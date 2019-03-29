<?php
/* @var $model \shop\forms\manage\Shop\Product\ProductCreateForm*/
?>
<div class="box box-default">
        <div class="box-header with-border"></div>
        <div class="box-body">
            <?= $form->field($model->meta, 'title')->textInput() ?>
            <?= $form->field($model->meta, 'description')->textarea(['rows' => 2]) ?>
            <?= $form->field($model->meta, 'keywords')->textInput() ?>
        </div>
    </div>