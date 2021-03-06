<?php

namespace frontend\modules\admin\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "news".
 *
 * @property int $news_id
 * @property string $date
 * @property int $theme_id
 * @property string $text
 * @property string $title
 *
 * @property Themes $theme
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'theme_id', 'text', 'title'], 'required'],
            [['date'], 'safe'],
            [['theme_id'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['theme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Themes::className(), 'targetAttribute' => ['theme_id' => 'theme_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'news_id' => 'News ID',
            'date' => 'Date',
            'theme_id' => 'Theme ID',
            'text' => 'Text',
            'title' => 'Title',
        ];
    }


    /**
     * Получение списка тем
     * Theme
     */
    public function getThemes()
    {
        $query = Yii::$app->db->createCommand('SELECT * FROM themes')->queryAll();
        $themes = ArrayHelper::map($query, 'theme_id', 'theme_title');
        return $themes;
    }

    /**
     * Gets query for [[Theme]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(Themes::className(), ['theme_id' => 'theme_id']);
    }
}
