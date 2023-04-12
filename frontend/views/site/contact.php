<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\ContactForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\captcha\Captcha;
use frontend\widgets\altControl\ALTControlWidget;

$this->title = $page['meta_title'];
$this->registerMetaTag(['name' => 'description', 'content' => $page['meta_description']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page['meta_keywords']]);
$this->params['breadcrumbs'][] = $page['menu_name'];
?>
<div class="about-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4"><?php echo $page['header'] . ALTControlWidget::widget(['method' => 'systemPagePanel', 'data' => ['key' => 'contact']]); ?></h1>
        </div>
    </div>

    <div class="body-content">
        <?php echo $page['text']; ?>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <?php
            /*
            $form = ActiveForm::begin(['id' => 'contact-form']);
            echo $form->field($model, 'name')->textInput(['autofocus' => true]);
            echo $form->field($model, 'email');
            echo $form->field($model, 'subject');
            echo $form->field($model, 'body')->textarea(['rows' => 6]);

            echo $form->field($model, 'verifyCode')->widget(Captcha::class, [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            ]);
            <div class="form-group">
                <?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']); ?>
            </div>
            ActiveForm::end();
            */
            ?>
        </div>
    </div>

</div>