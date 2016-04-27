<?php

namespace app\base\helpers;

use yii\helpers\ArrayHelper;

/**
 * Class RequestAttributesHelper
 * @package app\base\helpers
 */
class RequestAttributesHelper
{
    /**
     * Return params for action from request.
     *
     * @param array $params
     *
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public static function actionParams(array $params = [])
    {
        return ArrayHelper::merge(
            static::actionBodyParams(),
            UtilHelper::arrayKeysCamelize(\Yii::$app->getRequest()->getQueryParams()),
            $params
        );
    }

    /**
     * Return http BODY params for action from request.
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function actionBodyParams()
    {
        return UtilHelper::arrayKeysCamelize(\Yii::$app->getRequest()->getBodyParams());
    }
}