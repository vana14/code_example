<?php

namespace app\modules\test\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class Article extends base\Article
{
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[static::SCENARIO_DEFAULT] = [
            'id',
            'title',
            'alias',
            'alias',
            'annotation',
            'description',
        ];

        $scenarios[static::SCENARIO_UPDATE] = $scenarios[static::SCENARIO_CREATE] = $scenarios[static::SCENARIO_DEFAULT];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = [
            'slug' => [
                'class' => 'Zelenin\yii\behaviors\Slug',
                'slugAttribute' => 'alias',
                'attribute' => 'title',
                'ensureUnique' => false,
                'replacement' => '_',
                'lowercase' => true,
                'immutable' => false,
                // If intl extension is enabled, see http://userguide.icu-project.org/transforms/general.
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ],
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
        ];

        return ArrayHelper::merge(parent::behaviors(), $behaviors);
    }
}