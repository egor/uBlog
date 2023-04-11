<?php

use yii\helpers\Html;


$this->title = Yii::t('app', 'Update: {name}', [
    'name' => $model->page_key,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System page setting'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update') . ': ' . $model->page_key;
?>
<div class="altsystempagesetting-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
