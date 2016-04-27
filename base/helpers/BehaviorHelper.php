<?php

namespace app\base\helpers;

use app\base\behaviors\ParamsValidator;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\web\Response;

/**
 * Class BehaviorHelper
 * @package app\base\helpers
 */
class BehaviorHelper
{
    /**
     * Specified all required behaviors
     * @return array
     */
    public static function getRestBehaviors()
    {
        $behaviors = [
            'corsFilter'      => [
                'class' => Cors::className(),
            ],
            'bootstrap'       => [
                'class'   => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
            ],
            'paramsValidator' => [
                'class' => ParamsValidator::className(),
            ],
        ];

        if (defined('API_IGNORE_AUTH') && API_IGNORE_AUTH) {
            unset($behaviors['authenticator']);
        }

        return $behaviors;
    }
}