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

        //systemPageSetting
        $systemPageSettingDefault = $auth->createPermission('manageSystemPageSettingDefault');
        $systemPageSettingDefault->description = 'Manage system page setting';
        $auth->add($systemPageSettingDefault);
        $systemPageSettingDefaultIndex = $auth->createPermission('manageSystemPageSettingDefaultIndex');
        $systemPageSettingDefaultIndex->description = 'View system page setting list';
        $auth->add($systemPageSettingDefaultIndex);
        $systemPageSettingDefaultUpdate = $auth->createPermission('manageSystemPageSettingDefaultUpdate');
        $systemPageSettingDefaultUpdate->description = 'Update system page setting post';
        $auth->add($systemPageSettingDefaultUpdate);

        //page
        $pageDefault = $auth->createPermission('managePageDefault');
        $pageDefault->description = 'Manage page';
        $auth->add($pageDefault);
        $pageDefaultIndex = $auth->createPermission('managePageDefaultIndex');
        $pageDefaultIndex->description = 'View page list';
        $auth->add($pageDefaultIndex);
        $pageDefaultCreate = $auth->createPermission('managePageDefaultCreate');
        $pageDefaultCreate->description = 'Create new page post';
        $auth->add($pageDefaultCreate);
        $pageDefaultUpdate = $auth->createPermission('managePageDefaultUpdate');
        $pageDefaultUpdate->description = 'Update page post';
        $auth->add($pageDefaultUpdate);
        $pageDefaultDelete = $auth->createPermission('managePageDefaultDelete');
        $pageDefaultDelete->description = 'Delete page post';
        $auth->add($pageDefaultDelete);
        $pageDefaultView = $auth->createPermission('managePageDefaultView');
        $pageDefaultView->description = 'View page post data';
        $auth->add($pageDefaultView);

        $auth->addChild($blogDefault, $blogDefaultIndex);
        $auth->addChild($blogDefault, $blogDefaultCreate);
        $auth->addChild($blogDefault, $blogDefaultUpdate);
        $auth->addChild($blogDefault, $blogDefaultDelete);
        $auth->addChild($blogDefault, $blogDefaultView);

        $auth->addChild($systemPageSettingDefault, $systemPageSettingDefaultIndex);
        $auth->addChild($systemPageSettingDefault, $systemPageSettingDefaultUpdate);

        $auth->addChild($pageDefault, $pageDefaultIndex);
        $auth->addChild($pageDefault, $pageDefaultCreate);
        $auth->addChild($pageDefault, $pageDefaultUpdate);
        $auth->addChild($pageDefault, $pageDefaultDelete);
        $auth->addChild($pageDefault, $pageDefaultView);

        $auth->addChild($admin, $blogDefault);
        $auth->addChild($admin, $systemPageSettingDefault);
        $auth->addChild($admin, $pageDefault);

        $auth->addChild($moderator, $blogDefaultIndex);
        $auth->addChild($moderator, $blogDefaultView);
        $auth->addChild($moderator, $pageDefaultIndex);
        $auth->addChild($moderator, $pageDefaultView);

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
