<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $url
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $menu_name
 * @property string $header
 * @property string $short_text
 * @property string $text
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $displayed_at
 */
class Blog extends \yii\db\ActiveRecord
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

    const PAGINATION_PAGE_SIZE = 5;

    public $tags = '';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
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
            //[['url', 'meta_title', 'meta_keywords', 'meta_description', 'menu_name', 'header', 'short_text', 'text', 'status', 'created_at', 'updated_at', 'displayed_at'], 'required'],
            [['url', 'menu_name', 'header', 'displayed_at'], 'required'],
            [['short_text', 'text'], 'string'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['url', 'meta_title', 'meta_keywords', 'meta_description', 'menu_name', 'header'], 'string', 'max' => 255],
            [['url'], 'unique'],
            ['displayed_at', 'datetime', 'timestampAttribute' => 'displayed_at', 'format' => 'php:d.m.Y H:i'],
            ['tags', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'url' => Yii::t('app', 'Url'),
            'meta_title' => Yii::t('app', 'Meta Title'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'menu_name' => Yii::t('app', 'Menu Name'),
            'header' => Yii::t('app', 'Header'),
            'short_text' => Yii::t('app', 'Short Text'),
            'text' => Yii::t('app', 'Text'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'displayed_at' => Yii::t('app', 'Displayed At'),
            'tags' => Yii::t('app', 'Tags'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BlogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlogQuery(get_called_class());
    }

    public function getTagList()
    {
        return $this
            ->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('blog_tag', ['blog_id' => 'id']);
    }
}
