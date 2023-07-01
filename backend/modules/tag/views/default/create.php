<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\ALTTag $model */

$this->title = Yii::t('app', 'Create Alt Tag');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alt Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alttag-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
