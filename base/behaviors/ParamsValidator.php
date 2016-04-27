<?php

namespace app\base\behaviors;

use app\base\exceptions\InvalidArgumentException;
use app\base\helpers\RequestAttributesHelper;
use yii\base\Action;
use yii\base\ActionEvent;
use yii\base\Behavior;
use yii\base\Controller as BaseController;
use yii\base\DynamicModel;
use yii\base\InlineAction;
use yii\helpers\ArrayHelper;

/**
 * Class ParamsValidator
 * @package app\base\behaviors
 */
class ParamsValidator extends Behavior
{
    /**
     * @var DynamicModel
     */
    private $validationModel;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [BaseController::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    /**
     * @param ActionEvent $event
     */
    public function beforeAction($event)
    {
        $action = $event->action;

        if (!$this->validate($action, $this->prepareParams($action, RequestAttributesHelper::actionParams()))) {
            throw new InvalidArgumentException(\Yii::t('exceptions', 'Parameters is not valid: {0}', implode(', ', $this->validationModel->getFirstErrors())));
        }
    }

    /**
     * Validate action params.
     *
     * @param action $action
     * @param array  $params
     *
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    private function validate($action, array $params = [])
    {
        if (is_object($action->controller) && method_exists($action->controller, 'rules')) {
            $actionRules = ArrayHelper::getValue($action->controller->rules(), $action->id);
        } else {
            $actionRules = [];
        }

        if ($actionRules) {
            $this->validationModel = DynamicModel::validateData($params, $actionRules);

            return !$this->validationModel->hasErrors();
        }

        return true;
    }

    /**
     * Prepare params for validation.
     *
     * @param Action $action
     * @param array  $params
     *
     * @return array
     */
    private function prepareParams($action, array $params = [])
    {
        if ($action instanceof InlineAction) {
            $method = new \ReflectionMethod($action->controller, $action->actionMethod);
        } else {
            $method = new \ReflectionMethod($action, 'run');
        }

        foreach ($method->getParameters() as $parameter) {
            if (!array_key_exists($parameter->name, $params)) {
                $params[$parameter->name] = null;
            }
        }

        return $params;
    }
}