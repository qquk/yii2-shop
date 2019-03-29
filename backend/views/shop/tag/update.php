<?php

/* @var $this yii\web\View */
/* @var $model shop\forms\manage\Shop\Tag */
/** @var  \shop\entities\Shop\Tag $tag */

$this->title = 'Update Tag: ' .  $tag->name;
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>