<?php

namespace frontend\modules\blog\controllers;

use frontend\components\GetDisplayConditions;
use frontend\controllers\FrontendController;
use frontend\models\FrontTag;
use yii\data\ActiveDataProvider;
use frontend\models\FrontBlog;
use Yii;
use yii\db\Query;

/**
 * Default controller for the `blog` module
 */
class TagController extends FrontendController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        //@todo replace to tag
        $sql = "SELECT * FROM `system_page_setting` WHERE `page_key` = 'blog' " . GetDisplayConditions::systemPage('AND');
        $page = Yii::$app->db->createCommand($sql)->queryOne();
        if ($page) {
            $dataProvider = new ActiveDataProvider([
                'query' => FrontTag::find(),//FrontBlog::find()->where(GetDisplayConditions::blogPost())->orderBy('`displayed_at` DESC'),
                'pagination' => [
                    'pageSize' => FrontTag::PAGINATION_PAGE_SIZE,
                    'defaultPageSize' => FrontTag::PAGINATION_PAGE_SIZE,
                ],
            ]);
            return $this->render('index', ['page' => $page, 'dataProvider' => $dataProvider]);
        } else {
            throw new \yii\web\NotFoundHttpException();
        }
    }

    public function actionDetail($url) {
            $sql = "SELECT * FROM `tag` WHERE REPLACE(`name`, ' ', '_') = :name LIMIT 1";
            $sqlParams = [':name' => $url];
            $tag = Yii::$app->db->createCommand($sql, $sqlParams)->queryOne();
            if ($tag) {
                //$blog = FrontBlog::find()->where(GetDisplayConditions::blogPost())->orderBy('`displayed_at` DESC')->all();
                $query = new Query();
                $query->select('*')
                    ->from('blog')
                    ->leftJoin('blog_tag', 'blog_tag.blog_id = blog.id')
                    ->leftJoin('tag', 'tag.id = blog_tag.tag_id')
                    ->where('blog_tag.id = ' . $tag['id'])
                    ->orderBy('`displayed_at` DESC');
                //$query->
//print_r(); die;


                $dataProvider = new ActiveDataProvider([
                    'query' => FrontBlog::find()->joinWith('tagList')->where('tag.id="' . $tag['id'] . '"' . GetDisplayConditions::blogPost('AND'))->orderBy('`displayed_at` DESC'),//$query, //FrontBlog::find()->where("" . GetDisplayConditions::blogPost('AND'))->orderBy('`displayed_at` DESC'),
                    'pagination' => [
                        'pageSize' => FrontTag::PAGINATION_PAGE_SIZE,
                        'defaultPageSize' => FrontTag::PAGINATION_PAGE_SIZE,
                    ],
                ]);

                //$this->view->title = $blog['meta_title'];
                //$this->view->registerMetaTag(['name' => 'description', 'content' => $blog['meta_description']]);
                //$this->view->registerMetaTag(['name' => 'keywords', 'content' => $blog['meta_keywords']]);
                return $this->render('detail', ['tag' => $tag, 'dataProvider' => $dataProvider]);
            } else {
                throw new \yii\web\NotFoundHttpException();
            }
    }

}
