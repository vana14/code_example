<?php

namespace app\base\behaviors;

use app\base\exceptions\InvalidArgumentException;
use app\base\helpers\RequestAttributesHelper;
use yii\base\Behavior;
use yii\base\Controller;
use yii\base\Event;
use yii\rest\Action;

/**
 * Class CheckPrimaryKeyBehavior
 * @package app\base\behaviors
 */
class CheckPrimaryKeyBehavior extends Behavior
{
    /**
     * @var array
     */
    public $checkActions = [];

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    /**
     * @param Event $event
     */
    public function beforeAction(Event $event)
    {
        /** @var Action $action */
        $action = $event->action;

        if ($action instanceof Action
            && in_array($action->id, (array)$this->checkActions)
            && array_intersect(
                array_keys(RequestAttributesHelper::actionBodyParams()),
                call_user_func([$action->modelClass, 'primaryKey'])
            )
        ) {
            throw new InvalidArgumentException(\Yii::t('exceptions', 'Don`t send primary key data in {0} method', $action->id));

        }
    }
}