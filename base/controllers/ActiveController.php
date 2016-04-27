<?php

namespace app\base\controllers;

use app\base\ActiveRecord;
use app\base\behaviors\CheckPrimaryKeyBehavior;
use app\base\exceptions\BadMethodCallException;
use app\base\helpers\BehaviorHelper;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Class ActiveController
 * @package app\base
 */
class ActiveController extends \yii\rest\ActiveController
{
    const DEFAULT_OFFSET     = 0;
    const DEFAULT_PAGE_LIMIT = 10;

    /**
     * @inheritdoc
     */
    public $updateScenario = ActiveRecord::SCENARIO_UPDATE;

    /**
     * @inheritdoc
     */
    public $createScenario = ActiveRecord::SCENARIO_CREATE;


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
            \yii\rest\ActiveController::behaviors(),
            BehaviorHelper::getRestBehaviors(),
            [
                'checkPrimaryKey' => [
                    'class'        => CheckPrimaryKeyBehavior::className(),
                    'checkActions' => ['create', 'update'],
                ],
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function actions()
    {
        $actions = parent::actions();

        $actions['index'] = [
            'class'               => 'yii\rest\IndexAction',
            'modelClass'          => $this->modelClass,
            'checkAccess'         => [$this, 'checkAccess'],
            'prepareDataProvider' => function ($action) {
                $params = \Yii::$app->getRequest()->getQueryParams();
                $filter = ArrayHelper::getValue($params, 'filter', []);
                $offset = ArrayHelper::getValue($params, 'offset', static::DEFAULT_OFFSET);
                $limit  = ArrayHelper::getValue($params, 'limit', static::DEFAULT_PAGE_LIMIT);
                $offset = $offset < 0 ? 0 : $offset;

                /* @var $modelClass \yii\db\ActiveRecord */
                $modelClass = $action->modelClass;
                $query      = $modelClass::find();
                $columns    = $modelClass::getTableSchema()->columns;

                foreach (array_keys($filter) AS $key) {
                    if (!array_key_exists($key, $columns)) {
                        throw new BadMethodCallException(
                            \Yii::t('exceptions', 'Filter parameter {0} not defined', htmlspecialchars($key))
                        );
                    }
                }

                $query->onCondition($filter);

                return new ActiveDataProvider([
                    'pagination' => false,
                    'query'      => $query
                        ->offset($offset)
                        ->limit($limit),
                ]);
            },
        ];

        return $actions;
    }
}