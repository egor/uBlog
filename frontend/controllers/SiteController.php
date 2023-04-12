<?php

namespace frontend\controllers;

use common\models\SystemPageSetting;
use frontend\components\GetDisplayConditions;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends FrontendController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            /*
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            */
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $sql = "SELECT * FROM `system_page_setting` WHERE `page_key` = 'main'";
        $page = Yii::$app->db->createCommand($sql)->queryOne();
        if ($page) {
            return $this->render('index', ['page' => $page]);
        } else {
            return $this->render('info', [
                'page' => ['meta_title' => Yii::t('app', 'Error'), 'header' => Yii::t('app', 'Something went wrong. Check UBlog settings.'), 'text' => '']
            ]);
        }
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        $sql = "SELECT * FROM `system_page_setting` WHERE `page_key` = 'login' " . GetDisplayConditions::systemPage('AND');
        $page = Yii::$app->db->createCommand($sql)->queryOne();
        if ($page) {
            return $this->render('login', [
                'page' => $page,
                'model' => $model,
            ]);
        } else {
            throw new \yii\web\NotFoundHttpException();
        }

    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        /*
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        */
        $sql = "SELECT * FROM `system_page_setting` WHERE `page_key` = 'contact' " . GetDisplayConditions::systemPage('AND');
        $page = Yii::$app->db->createCommand($sql)->queryOne();
        if ($page) {
            return $this->render('contact', [
                'page' => $page
                //'model' => $model,
            ]);
        } else {
            throw new \yii\web\NotFoundHttpException();
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        $sql = "SELECT * FROM `system_page_setting` WHERE `page_key` = 'about' " . GetDisplayConditions::systemPage('AND');
        $page = Yii::$app->db->createCommand($sql)->queryOne();
        if ($page) {
            return $this->render('about', ['page' => $page]);
        } else {
            throw new \yii\web\NotFoundHttpException();
        }
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        $sql = "SELECT * FROM `system_page_setting` WHERE `page_key` = 'signup' " . GetDisplayConditions::systemPage('AND');
        $page = Yii::$app->db->createCommand($sql)->queryOne();
        if ($page) {
            return $this->render('signup', [
                'page' => $page,
                'model' => $model,
            ]);
        } else {
            throw new \yii\web\NotFoundHttpException();
        }
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        $sql = "SELECT * FROM `system_page_setting` WHERE `page_key` = 'requestPasswordResetToken' " . GetDisplayConditions::systemPage('AND');
        $page = Yii::$app->db->createCommand($sql)->queryOne();
        if ($page) {
            return $this->render('requestPasswordResetToken', [
                'page' => $page,
                'model' => $model,
            ]);
        } else {
            throw new \yii\web\NotFoundHttpException();
        }

    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        $sql = "SELECT * FROM `system_page_setting` WHERE `page_key` = 'resetPassword' " . GetDisplayConditions::systemPage('AND');
        $page = Yii::$app->db->createCommand($sql)->queryOne();
        if ($page) {
            return $this->render('resetPassword', [
                'page' => $page,
                'model' => $model,
            ]);
        } else {
            throw new \yii\web\NotFoundHttpException();
        }
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        $sql = "SELECT * FROM `system_page_setting` WHERE `page_key` = 'resendVerificationEmail' " . GetDisplayConditions::systemPage('AND');
        $page = Yii::$app->db->createCommand($sql)->queryOne();
        if ($page) {
            return $this->render('resendVerificationEmail', [
                'page' => $page,
                'model' => $model,
            ]);
        } else {
            throw new \yii\web\NotFoundHttpException();
        }
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            if ($exception->statusCode == 404) {
                $sql = "SELECT * FROM `system_page_setting` WHERE `page_key` = '404'";
                $page = Yii::$app->db->createCommand($sql)->queryOne();
                return $this->render('error404', ['page' => $page]);
            }
            $statusCode = $exception->statusCode;
            $name = $exception->getName();
            $message = $exception->getMessage();
            return $this->render('error', [
                'exception' => $exception,
                'statusCode' => $statusCode,
                'name' => $name . ' (#' . $statusCode . ')',
                'message' => $message
            ]);
        }
    }
}
