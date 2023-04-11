<?php

use backend\models\ALTBlog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\BlogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Blog posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="altblog-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create blog post'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'url:url',
            //'meta_title',
            //'meta_keywords',
            //'meta_description',
            'menu_name',
            //'header',
            //'short_text:ntext',
            //'text:ntext',
            //'status',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($data) {
                    switch ($data['status']) {
                        case ALTBlog::STATUS_NOT_SHOW:
                            return '<i class="fa-solid fa-eye-slash" title="' . Yii::t('app', 'Do not show to anyone') . '"></i>';
                        case ALTBlog::STATUS_SHOW_EVERYONE:
                            return '<i class="fa-solid fa-eye" title="' . Yii::t('app', 'Show to anyone') . '"></i>';
                        case ALTBlog::STATUS_SHOW_ONLY_TO_GUEST:
                            return '<i class="fa-solid fa-user-clock" title="' . Yii::t('app', 'Show only to guests') . '"></i>';
                        case ALTBlog::STATUS_SHOW_ONLY_TO_AUTH:
                            return '<i class="fa-solid fa-user-lock" title="' . Yii::t('app', 'Show only authorized user') . '"></i>';

                    }
                }
            ],
            //'created_at',
            //'updated_at',
            //'displayed_at:datetime',
            [
                'attribute' => 'displayed_at',
                'format' => ['datetime', 'php:d.m.Y H:i']
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ALTBlog $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
