<?php

namespace frontend\modules\blog\controllers;

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
        $dataProvider = new ActiveDataProvider([
            'query' => FrontBlog::find()->where($this->getDisplayConditions())->orderBy('`displayed_at` DESC'),
            'pagination' => [
                'pageSize' => FrontBlog::PAGINATION_PAGE_SIZE,
                'defaultPageSize' => FrontBlog::PAGINATION_PAGE_SIZE,
            ],
        ]);
        $this->view->title = 'Blog';
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionDetail($url) {
        $sql = "SELECT * FROM `blog` WHERE `url` = :url " . $this->getDisplayConditions('AND') . " LIMIT 1";
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

    public function getDisplayConditions($prefix = '') {
        if (Yii::$app->user->can('manageBlogDefaultIndex')) {
            return '';
        }
        $status = FrontBlog::STATUS_SHOW_EVERYONE;
        if (Yii::$app->user->isGuest) {
            $status .= ',' . FrontBlog::STATUS_SHOW_ONLY_TO_GUEST;
        } else {
            $status .= ',' . FrontBlog::STATUS_SHOW_ONLY_TO_AUTH;
        }
        return ' ' . $prefix . ' `displayed_at` <= ' . time() . ' AND `status` IN (' . $status . ') ';
    }
}
