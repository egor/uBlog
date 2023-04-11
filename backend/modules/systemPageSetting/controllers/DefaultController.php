<?php

namespace backend\modules\systemPageSetting\controllers;

use backend\models\ALTSystemPageSetting;
use common\models\SystemPageSettingSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `systemPageSetting` module
 */
class DefaultController extends Controller
{
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
                        'roles' => ['manageSystemPageSettingDefault'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['manageSystemPageSettingDefaultIndex'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['manageSystemPageSettingDefaultUpdate'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SystemPageSettingSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->sort->defaultOrder = ['position' => SORT_ASC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($key)
    {
        $model = $this->findModel($key);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            if (isset($_POST['saveAndExit'])) {
                return $this->redirect(['index']);
            } else if (isset($_POST['saveAndGoToPage'])) {
                return $this->redirect('/' . $model->url);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    protected function findModel($key)
    {
        if (($model = ALTSystemPageSetting::findOne(['page_key' => $key])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
