<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use backend\models\ALTPage;
use yii\bootstrap5\ActiveForm;
use kartik\date\DatePicker;
use vova07\imperavi\Widget;

/** @var yii\web\View $this */
/** @var backend\models\ALTPage $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="altpage-form">

    <?php
    $form = ActiveForm::begin();

    //echo $form->field($model, 'pid')->textInput();
    echo $form->field($model, 'url')->textInput(['maxlength' => true]);
    echo $form->field($model, 'meta_title')->textInput(['maxlength' => true]);
    echo $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]);
    echo $form->field($model, 'meta_description')->textInput(['maxlength' => true]);
    ?>
    <div class="row">
        <div class="col">
            <?php
            echo $form->field($model, 'status')->dropDownList([
                ALTPage::STATUS_NOT_SHOW => Yii::t('app', 'Do not show to anyone'),
                ALTPage::STATUS_SHOW_EVERYONE => Yii::t('app', 'Show to anyone'),
                ALTPage::STATUS_SHOW_ONLY_TO_GUEST => Yii::t('app', 'Show only to guests'),
                ALTPage::STATUS_SHOW_ONLY_TO_AUTH => Yii::t('app', 'Show only authorized user'),
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
        <div class="col">
            <?php
            echo $form->field($model, 'position')->textInput();
            ?>
        </div>
    </div>
    <?php
    echo $form->field($model, 'menu_name')->textInput(['maxlength' => true]);
    echo $form->field($model, 'header')->textInput(['maxlength' => true]);
    //echo $form->field($model, 'short_text')->textarea(['rows' => 6]);
    echo $form->field($model, 'short_text')->widget(Widget::className(), [
        'settings' => [
            'minHeight' => 200,
            'plugins' => [
                'clips',
                'fullscreen',
            ],
        ],
    ]);
    //echo $form->field($model, 'text')->textarea(['rows' => 6]);
    echo $form->field($model, 'text')->widget(Widget::className(), [
        'settings' => [
            'minHeight' => 400,
            'plugins' => [
                'clips',
                'fullscreen',
            ],
        ],
    ]);
    //echo $form->field($model, 'status')->textInput();



    //echo $form->field($model, 'status_list')->textInput();
    //echo $form->field($model, 'created_at')->textInput();
    //echo $form->field($model, 'updated_at')->textInput();
    //echo $form->field($model, 'displayed_at')->textInput();


    ?>

    <div class="form-group float-end pb-5">
        <?php
        echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'name' => 'save']) . ' &nbsp; ';
        echo Html::submitButton(Yii::t('app', 'Save and exit'), ['class' => 'btn btn-dark', 'name' => 'saveAndExit']) . ' &nbsp; ';
        echo Html::submitButton(Yii::t('app', 'Save and go to page'), ['class' => 'btn btn-dark', 'name' => 'saveAndGoToPage']) . ' &nbsp; ';
        if (!$model->isNewRecord) {
            echo '<a href="/' . $model->url . '" class="btn btn-light">' . Yii::t('app', 'Cancel and go to page') . '</a>';
        }
        echo '<a href="/altadmin/page" class="btn btn-light">' . Yii::t('app', 'Cancel') . '</a>';
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
