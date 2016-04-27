<?php

namespace app\base;

use app\base\helpers\ModelHelper;
use yii\helpers\ArrayHelper;

/**
 * Class ActiveRecord
 * @package app\base
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritDoc
     */
    public function scenarios()
    {
        return ArrayHelper::merge(
            parent::scenarios(),
            [
                static::SCENARIO_DEFAULT => $this->attributes(),
                static::SCENARIO_CREATE  => $this->attributes(),
                static::SCENARIO_UPDATE  => $this->attributes()
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        return ModelHelper::filterOutput($this, parent::toArray($fields ?: $this->safeAttributes(), $expand, $recursive));
    }
}