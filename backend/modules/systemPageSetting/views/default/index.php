<?php

use backend\models\ALTSystemPageSetting;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;



$this->title = Yii::t('app', 'System page setting');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="altsystempagesetting-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'page_key',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($data) {
                    switch ($data['status']) {
                        case ALTSystemPageSetting::STATUS_NOT_SHOW:
                            return '<i class="fa-solid fa-eye-slash" title="' . Yii::t('app', 'Do not show to anyone') . '"></i>';
                        case ALTSystemPageSetting::STATUS_SHOW_EVERYONE:
                            return '<i class="fa-solid fa-eye" title="' . Yii::t('app', 'Show to anyone') . '"></i>';
                        case ALTSystemPageSetting::STATUS_SHOW_ONLY_TO_GUEST:
                            return '<i class="fa-solid fa-user-clock" title="' . Yii::t('app', 'Show only to guests') . '"></i>';
                        case ALTSystemPageSetting::STATUS_SHOW_ONLY_TO_AUTH:
                            return '<i class="fa-solid fa-user-lock" title="' . Yii::t('app', 'Show only authorized user') . '"></i>';

                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        return '<a href="/altadmin/systemPageSetting/default/update?key=' . $model->page_key . '"><i class="fa-solid fa-pen"></i></a>';
                    }
                ]
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
