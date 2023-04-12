<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\ALTPage $model */

$this->title = Yii::t('app', 'Update Page: {name}', [
    'name' => $model->menu_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update: ' . $model->menu_name);
?>
<div class="altpage-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
