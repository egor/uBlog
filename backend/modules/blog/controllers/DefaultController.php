<?php

namespace backend\modules\blog\controllers;

use backend\models\ALTBlog;
use common\models\Blog;
use common\models\BlogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DefaultController implements the CRUD actions for ALTBlog model.
 */
class DefaultController extends Controller
{

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['manageBlogDefault'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['manageBlogDefaultIndex'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['manageBlogDefaultView'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['manageBlogDefaultCreate'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['manageBlogDefaultUpdate'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['manageBlogDefaultDelete'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all ALTBlog models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ALTBlog model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ALTBlog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ALTBlog();
        $model->displayed_at = date('d.m.Y H:i');
        $model->status = Blog::STATUS_SHOW_EVERYONE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $displayedAt = $model->displayed_at;
                $model->displayed_at = strtotime($model->displayed_at);

                if ($model->save()) {
                    if (isset($_POST['saveAndExit'])) {
                        return $this->redirect(['index']);
                    } else if (isset($_POST['saveAndGoToPage'])) {
                        return $this->redirect('/blog/' . $model->url);
                    } else {
                        return $this->redirect(['update', 'id' => $model->id]);
                    }
                } else {
                    $model->displayed_at = $displayedAt; //date('d.m.Y H:i', $model->displayed_at);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ALTBlog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            if (isset($_POST['saveAndExit'])) {
                return $this->redirect(['index']);
            } else if (isset($_POST['saveAndGoToPage'])) {
                return $this->redirect('/blog/' . $model->url);
            }
        } else {
            $model->displayed_at = date('d.m.Y H:i', $model->displayed_at);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ALTBlog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $redirectTo = '')
    {
        $this->findModel($id)->delete();

        if ($redirectTo == 'site') {
            return $this->redirect('/blog');
        } else {
            return $this->redirect(['index']);
        }

    }

    /**
     * Finds the ALTBlog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ALTBlog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ALTBlog::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionGoTo($id)
    {
        $model = ALTBlog::findOne($id);
        return $this->redirect('/blog/' . $model->url);
    }
}
