<?php

namespace app\base;

use app\base\helpers\ModelHelper;
use yii\helpers\ArrayHelper;

/**
 * Class Model
 * @package app\base
 */
class Model extends \yii\base\Model
{
    const OUTPUT_TYPE_ARRAY       = 'array';
    const OUTPUT_TYPE_ASSOCIATIVE = 'associative';

    /**
     * @inheritDoc
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), ['default' => $this->attributes()]);
    }

    /**
     * @inheritdoc
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        return ModelHelper::filterOutput($this, parent::toArray($fields ?: $this->safeAttributes(), $expand, $recursive));
    }
}