<?php
namespace frontend\widgets\altControl;

use yii\base\Widget;
use Yii;

class ALTControlWidget extends Widget
{
    public $method = '';

    public $data = [];

    public function run()
    {
        Yii::$app->view->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css');
        if ((Yii::$app->user->can('manageBlogDefaultUpdate') || Yii::$app->user->can('manageBlogDefaultDelete')) && $this->method == 'editPanel') {
            return $this->render('editPanel', ['data' => $this->data]);
        }
    }
}