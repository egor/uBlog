<?php

namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class RbacController extends Controller
{

    public function actionInit()
    {
        return $this->start();
    }

    public function start()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        $admin = $auth->createRole('admin');
        $moderator = $auth->createRole('moderator');
        $user = $auth->createRole('user');

        $auth->add($admin);
        $auth->add($moderator);
        $auth->add($user);

        $CMSAccess = $auth->createPermission('CMSAccess');
        $CMSAccess->description = 'Access to CMS';
        $auth->add($CMSAccess);

        $auth->addChild($admin, $CMSAccess);
        $auth->addChild($moderator, $CMSAccess);

        //blog
        $blogDefault = $auth->createPermission('manageBlogDefault');
        $blogDefault->description = 'Manage blog';
        $auth->add($blogDefault);
        $blogDefaultIndex = $auth->createPermission('manageBlogDefaultIndex');
        $blogDefaultIndex->description = 'View blog list';
        $auth->add($blogDefaultIndex);
        $blogDefaultCreate = $auth->createPermission('manageBlogDefaultCreate');
        $blogDefaultCreate->description = 'Create new blog post';
        $auth->add($blogDefaultCreate);
        $blogDefaultUpdate = $auth->createPermission('manageBlogDefaultUpdate');
        $blogDefaultUpdate->description = 'Update blog post';
        $auth->add($blogDefaultUpdate);
        $blogDefaultDelete = $auth->createPermission('manageBlogDefaultDelete');
        $blogDefaultDelete->description = 'Delete blog post';
        $auth->add($blogDefaultDelete);
        $blogDefaultView = $auth->createPermission('manageBlogDefaultView');
        $blogDefaultView->description = 'View blog post data';
        $auth->add($blogDefaultView);

        $auth->addChild($blogDefault, $blogDefaultIndex);
        $auth->addChild($blogDefault, $blogDefaultCreate);
        $auth->addChild($blogDefault, $blogDefaultUpdate);
        $auth->addChild($blogDefault, $blogDefaultDelete);
        $auth->addChild($blogDefault, $blogDefaultView);

        $auth->addChild($admin, $blogDefault);
        $auth->addChild($moderator, $blogDefaultIndex);
        $auth->addChild($moderator, $blogDefaultView);

        $userData = User::find()->all();
        foreach ($userData as $userValue) {
            $userRole = $userValue->role;
            $auth->assign($$userRole, $userValue->id);
        }
    }
    public function actionAddAdmin()
    {
        $model = User::find()->where(['username' => 'Admin'])->one();
        if (empty($model)) {
            $user = new User();
            $user->username = 'Admin';
            $user->email = 'admin@devreadwrite.com';
            $user->setPassword('MySuper100%PasswordOK7');
            $user->status = User::STATUS_ACTIVE;
            $user->generateAuthKey();
            $user->role = 'admin';
            if ($user->save()) {
                echo "User added\n";
            }
            $this->start();
        }
        return ExitCode::OK;
    }

    public function actionInitAdmin($email)
    {
        $user = User::findOne(['email' => $email]);
        if ($user) {
            $auth = Yii::$app->authManager;
            $auth->revokeAll($user->id);
            $adminRole = $auth->getRole('admin');
            $auth->assign($adminRole, $user->id);
            echo "The user [$email] is assigned a role: admin\n";
            return 0;
        }
        echo "User [$email] is not found\n";
        return 1;
    }

}
