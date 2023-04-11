<?php
use yii\widgets\ListView;

$this->title = Yii::t('app', 'Blog');
$this->params['breadcrumbs'][] = $this->title;

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_list',
    'pager' => [
        'class' => 'yii\bootstrap5\LinkPager',
    ]
]);