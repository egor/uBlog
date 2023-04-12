<?php

namespace backend\modules\page\controllers;

use backend\models\ALTPage;
use common\models\PageSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for ALTPage model.
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
                        'roles' => ['managePageDefault'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['managePageDefaultIndex'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['managePageDefaultView'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['managePageDefaultCreate'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['managePageDefaultUpdate'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['managePageDefaultDelete'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all ALTPage models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ALTPage model.
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
     * Creates a new ALTPage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ALTPage();
        $model->displayed_at = date('d.m.Y H:i');
        $model->status = ALTPage::STATUS_SHOW_EVERYONE;
        $model->position = 1000;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $displayedAt = $model->displayed_at;
                $model->displayed_at = strtotime($model->displayed_at);

                if ($model->save()) {
                    if (isset($_POST['saveAndExit'])) {
                        return $this->redirect(['index']);
                    } else if (isset($_POST['saveAndGoToPage'])) {
                        return $this->redirect('/page/' . $model->url);
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
     * Updates an existing ALTPage model.
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
                return $this->redirect('/page/' . $model->url);
            }
        } else {
        //    $model->displayed_at = date('d.m.Y H:i', $model->displayed_at);
        }
        if (is_int($model->displayed_at)) {
            $model->displayed_at = date('d.m.Y H:i', $model->displayed_at);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ALTPage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ALTPage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ALTPage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ALTPage::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
