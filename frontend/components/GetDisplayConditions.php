<?php
namespace frontend\components;

use common\models\SystemPageSetting;
use frontend\models\FrontBlog;
use frontend\models\FrontPage;
use Yii;

class GetDisplayConditions
{
    public static function systemPage($prefix)
    {
        if (Yii::$app->user->can('manageSystemPageSettingDefaultUpdate')) {
            return '';
        }
        $status = SystemPageSetting::STATUS_SHOW_EVERYONE;
        if (Yii::$app->user->isGuest) {
            $status .= ',' . SystemPageSetting::STATUS_SHOW_ONLY_TO_GUEST;
        } else {
            $status .= ',' . SystemPageSetting::STATUS_SHOW_ONLY_TO_AUTH;
        }
        return ' ' . $prefix . ' `status` IN (' . $status . ') ';
    }

    public static function blogPost($prefix = '') {
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

    public static function pagePost($prefix = '') {
        if (Yii::$app->user->can('managePageDefaultIndex')) {
            return '';
        }
        $status = FrontPage::STATUS_SHOW_EVERYONE;
        if (Yii::$app->user->isGuest) {
            $status .= ',' . FrontPage::STATUS_SHOW_ONLY_TO_GUEST;
        } else {
            $status .= ',' . FrontPage::STATUS_SHOW_ONLY_TO_AUTH;
        }
        return ' ' . $prefix . ' `displayed_at` <= ' . time() . ' AND `status` IN (' . $status . ') ';
    }
}