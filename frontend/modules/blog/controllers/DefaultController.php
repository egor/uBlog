<?php

namespace frontend\modules\blog\controllers;

use frontend\components\GetDisplayConditions;
use frontend\controllers\FrontendController;
use yii\data\ActiveDataProvider;
use frontend\models\FrontBlog;
use Yii;

/**
 * Default controller for the `blog` module
 */
class DefaultController extends FrontendController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $sql = "SELECT * FROM `system_page_setting` WHERE `page_key` = 'blog' " . GetDisplayConditions::systemPage('AND');
        $page = Yii::$app->db->createCommand($sql)->queryOne();
        if ($page) {
            $dataProvider = new ActiveDataProvider([
                'query' => FrontBlog::find()->where(GetDisplayConditions::blogPost())->orderBy('`displayed_at` DESC'),
                'pagination' => [
                    'pageSize' => FrontBlog::PAGINATION_PAGE_SIZE,
                    'defaultPageSize' => FrontBlog::PAGINATION_PAGE_SIZE,
                ],
            ]);
            return $this->render('index', ['page' => $page, 'dataProvider' => $dataProvider]);
        } else {
            throw new \yii\web\NotFoundHttpException();
        }
    }

    public function actionDetail($url) {
        $sql = "SELECT * FROM `blog` WHERE `url` = :url " . GetDisplayConditions::blogPost('AND') . " LIMIT 1";
        $sqlParams = [':url' => $url];
        $blog = Yii::$app->db->createCommand($sql, $sqlParams)->queryOne();

        if ($blog) {
            $this->view->title = $blog['meta_title'];
            $this->view->registerMetaTag(['name' => 'description', 'content' => $blog['meta_description']]);
            $this->view->registerMetaTag(['name' => 'keywords', 'content' => $blog['meta_keywords']]);
            return $this->render('detail', ['blog' => $blog]);
        } else {
            throw new \yii\web\NotFoundHttpException();
        }
    }

}
