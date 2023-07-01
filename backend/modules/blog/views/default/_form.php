<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap5\ActiveForm;
use kartik\date\DatePicker;
use common\models\Blog;
use kartik\select2\Select2;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var backend\models\ALTBlog $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="altblog-form">

    <?php

    $form = ActiveForm::begin();
    echo $form->field($model, 'url')->textInput(['maxlength' => true]);
    ?>
    <div class="row">
        <div class="col">
        <?php
        echo $form->field($model, 'status')->dropDownList([
            Blog::STATUS_NOT_SHOW => Yii::t('app', 'Do not show to anyone'),
            Blog::STATUS_SHOW_EVERYONE => Yii::t('app', 'Show to anyone'),
            Blog::STATUS_SHOW_ONLY_TO_GUEST => Yii::t('app', 'Show only to guests'),
            Blog::STATUS_SHOW_ONLY_TO_AUTH => Yii::t('app', 'Show only authorized user'),
        ], [/*'prompt' => Yii::t('app', 'Select post status')*/]);
        ?>
        </div>
        <div class="col">
        <?php
        echo $form->field($model, 'displayed_at')->widget(DatePicker::classname(), [
            //'options' => ['placeholder' => '...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy'
            ]
        ]);
        ?>
        </div>
    </div>
    <?php
    echo $form->field($model, 'meta_title')->textInput(['maxlength' => true]);
    echo $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]);
    echo $form->field($model, 'meta_description')->textInput(['maxlength' => true]);
    echo $form->field($model, 'menu_name')->textInput(['maxlength' => true]);
    echo $form->field($model, 'header')->textInput(['maxlength' => true]);
    echo $form->field($model, 'short_text')->textarea(['rows' => 6]);
    echo $form->field($model, 'text')->textarea(['rows' => 36]);
    //echo $form->field($model, 'tags')->textInput(['maxlength' => true]);
    ?>
    <div class="row">
        <div class="col">
    <?php


    //$model->tags =  ['red', 'green']; // initial value
    echo $form->field($model, 'tags')->widget(Select2::classname(), [
        'data' => [],
        'options' => ['placeholder' => 'Select a tag ...', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10,
            'ajax' => [
                'url' => '/altadmin/tag/default/get-list',
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(tags) { return tags.text; }'),
            'templateSelection' => new JsExpression('function (tags) { return tags.text; }'),
        ],
    ])->label('Tag Multiple');



    ?>
        </div>
    </div>
    <style>
        .select2-container--krajee-bs5 .select2-selection--multiple .select2-selection__choice{
            /*display: none;*/
            float:left;
        }
    </style>
    <div class="form-group float-end pb-5">
        <?php
        echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'name' => 'save']) . ' &nbsp; ';
        echo Html::submitButton(Yii::t('app', 'Save and exit'), ['class' => 'btn btn-dark', 'name' => 'saveAndExit']) . ' &nbsp; ';
        echo Html::submitButton(Yii::t('app', 'Save and go to page'), ['class' => 'btn btn-dark', 'name' => 'saveAndGoToPage']) . ' &nbsp; ';
        if (!$model->isNewRecord) {
            //echo '<a href="/altadmin/blog/default/go-to?id=' . $model->id . '" class="btn btn-light">' . Yii::t('app', 'Cancel and go to page') . '</a>';
            echo '<a href="/blog/' . $model->url . '" class="btn btn-light">' . Yii::t('app', 'Cancel and go to page') . '</a>';
        }
        echo '<a href="/altadmin/blog" class="btn btn-light">' . Yii::t('app', 'Cancel') . '</a>';
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
