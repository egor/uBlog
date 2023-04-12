<?php

namespace frontend\modules\page\controllers;

use frontend\components\GetDisplayConditions;
use yii\web\Controller;
use Yii;

/**
 * Default controller for the `page` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($url)
    {

        $sql = "SELECT * FROM `page` WHERE `url` = :url " . GetDisplayConditions::pagePost('AND') . " LIMIT 1";
        $sqlParams = [':url' => $url];
        $page = Yii::$app->db->createCommand($sql, $sqlParams)->queryOne();

        if ($page) {
            $this->view->title = $page['meta_title'];
            $this->view->registerMetaTag(['name' => 'description', 'content' => $page['meta_description']]);
            $this->view->registerMetaTag(['name' => 'keywords', 'content' => $page['meta_keywords']]);
            return $this->render('index', ['page' => $page]);
        } else {
            throw new \yii\web\NotFoundHttpException();
        }

    }
}
