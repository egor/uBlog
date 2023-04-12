<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property int $pid
 * @property string $url
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $menu_name
 * @property string $header
 * @property string $short_text
 * @property string $text
 * @property int $status
 * @property int $status_list
 * @property int $created_at
 * @property int $updated_at
 * @property int $displayed_at
 * @property int $position
 */
class Page extends \yii\db\ActiveRecord
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
        return 'page';
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
            //[['pid', 'url', 'meta_title', 'meta_keywords', 'meta_description', 'menu_name', 'header', 'short_text', 'text', 'status', 'status_list', 'created_at', 'updated_at', 'displayed_at', 'position'], 'required'],
            [['url', 'meta_title', 'menu_name', 'header'], 'required'],
            [['pid', 'status', 'status_list', 'created_at', 'updated_at', 'position'], 'integer'],
            [['short_text', 'text'], 'string'],
            [['url', 'meta_title', 'meta_keywords', 'meta_description', 'menu_name', 'header'], 'string', 'max' => 255],
            [['url'], 'unique'],
            ['displayed_at', 'datetime', 'timestampAttribute' => 'displayed_at', 'format' => 'php:d.m.Y H:i'],
            ['position', 'default', 'value' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pid' => Yii::t('app', 'Pid'),
            'url' => Yii::t('app', 'Url'),
            'meta_title' => Yii::t('app', 'Meta Title'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'menu_name' => Yii::t('app', 'Menu Name'),
            'header' => Yii::t('app', 'Header'),
            'short_text' => Yii::t('app', 'Short Text'),
            'text' => Yii::t('app', 'Text'),
            'status' => Yii::t('app', 'Status'),
            'status_list' => Yii::t('app', 'Status List'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'displayed_at' => Yii::t('app', 'Displayed At'),
            'position' => Yii::t('app', 'Position'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }
}
