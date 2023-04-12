<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use backend\models\ALTSystemPageSetting;
use vova07\imperavi\Widget;
?>

<div class="altsystempagesetting-form">

    <?php

    $form = ActiveForm::begin();
    echo $form->field($model, 'url')->textInput(['maxlength' => true]);

    echo $form->field($model, 'status')->dropDownList([
        ALTSystemPageSetting::STATUS_NOT_SHOW => Yii::t('app', 'Do not show to anyone'),
        ALTSystemPageSetting::STATUS_SHOW_EVERYONE => Yii::t('app', 'Show to anyone'),
        ALTSystemPageSetting::STATUS_SHOW_ONLY_TO_GUEST => Yii::t('app', 'Show only to guests'),
        ALTSystemPageSetting::STATUS_SHOW_ONLY_TO_AUTH => Yii::t('app', 'Show only authorized user'),
    ], [/*'prompt' => Yii::t('app', 'Select post status')*/]);

    echo $form->field($model, 'meta_title')->textInput(['maxlength' => true]);
    echo $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]);
    echo $form->field($model, 'meta_description')->textInput(['maxlength' => true]);
    echo $form->field($model, 'menu_name')->textInput(['maxlength' => true]);
    echo $form->field($model, 'header')->textInput(['maxlength' => true]);
    //echo $form->field($model, 'text')->textarea(['rows' => 36]);

    //https://github.com/vova07/yii2-imperavi-widget
    echo $form->field($model, 'text')->widget(Widget::className(), [
        'settings' => [
            //'lang' => 'ru',
            'minHeight' => 200,
            'plugins' => [
                'clips',
                'fullscreen',
            ],
            /*
            'clips' => [
                ['Lorem ipsum...', 'Lorem...'],
                ['red', '<span class="label-red">red</span>'],
                ['green', '<span class="label-green">green</span>'],
                ['blue', '<span class="label-blue">blue</span>'],
            ],
            */
        ],
    ]);
    ?>

    <div class="form-group float-end">
        <?php
        echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'name' => 'save']) . ' &nbsp; ';
        echo Html::submitButton(Yii::t('app', 'Save and exit'), ['class' => 'btn btn-dark', 'name' => 'saveAndExit']) . ' &nbsp; ';
        echo Html::submitButton(Yii::t('app', 'Save and go to page'), ['class' => 'btn btn-dark', 'name' => 'saveAndGoToPage']) . ' &nbsp; ';
        if (!$model->isNewRecord) {
            echo '<a href="/' . ($model->page_key == 'main' ? '' : $model->url) . '" class="btn btn-light">' . Yii::t('app', 'Cancel and go to page') . '</a>';
        }
        echo '<a href="/altadmin/systemPageSetting" class="btn btn-light">' . Yii::t('app', 'Cancel') . '</a>';
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
