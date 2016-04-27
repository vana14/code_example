<?php

namespace app\modules\test\models\base;

use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $annotation
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class Article extends \app\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias', 'description'], 'required'],
            [['annotation', 'description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'alias' => Yii::t('app', 'Alias'),
            'annotation' => Yii::t('app', 'Annotation'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
