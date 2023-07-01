<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "blog_tag".
 *
 * @property int $id
 * @property int $blog_id
 * @property int $tag_id
 */
class BlogTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['blog_id', 'tag_id'], 'required'],
            [['blog_id', 'tag_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'blog_id' => Yii::t('app', 'Blog ID'),
            'tag_id' => Yii::t('app', 'Tag ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BlogTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlogTagQuery(get_called_class());
    }

    public function getTag(){
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }
}
