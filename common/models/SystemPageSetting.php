<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "system_page_setting".
 *
 * @property int $id
 * @property string $page_key
 * @property string $url
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $menu_name
 * @property string $header
 * @property string $text
 * @property int $status
 * @property int $position
 * @property int $updated_at
 */
class SystemPageSetting extends \yii\db\ActiveRecord
{
    /**
     * Do not show to anyone except the admin
     */
    const STATUS_NOT_SHOW = 0;
    /**
     * Show to anyone
     */
    const STATUS_SHOW_EVERYONE = 1;
    /**
     * show only to guests (unauthorized)
     */
    const STATUS_SHOW_ONLY_TO_GUEST = 2;
    /**
     * Show only authorized user
     */
    const STATUS_SHOW_ONLY_TO_AUTH = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_page_setting';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['page_key', 'url', 'meta_title', 'meta_keywords', 'meta_description', 'menu_name', 'header', 'text', 'status', 'position', 'updated_at'], 'required'],
            [['page_key', 'url', 'meta_title', 'menu_name', 'header'], 'required'],
            [['text'], 'string'],
            [['status', 'position', 'updated_at'], 'integer'],
            [['page_key', 'url', 'meta_title', 'meta_keywords', 'meta_description', 'menu_name', 'header'], 'string', 'max' => 255],
            [['url'], 'unique'],
            [['page_key', 'url'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'page_key' => Yii::t('app', 'Page Key'),
            'url' => Yii::t('app', 'Url'),
            'meta_title' => Yii::t('app', 'Meta Title'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'menu_name' => Yii::t('app', 'Menu Name'),
            'header' => Yii::t('app', 'Header'),
            'text' => Yii::t('app', 'Text'),
            'status' => Yii::t('app', 'Status'),
            'position' => Yii::t('app', 'Position'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return SystemPageSettingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SystemPageSettingQuery(get_called_class());
    }
}
