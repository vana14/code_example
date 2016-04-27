<?php

namespace app\base\helpers;

use yii\base\Model;

/**
 * Class ModelHelper
 * @package app\base\helpers
 */
class ModelHelper
{
    /**
     * Return filtered output from model.
     *
     * @param Model $model
     * @param array $result
     *
     * @return array
     */
    public static function filterOutput(Model $model, array $result = [])
    {
        if (!$result) {
            $result = $model->getAttributes($model->safeAttributes());
        }

        foreach ($model->rules() as $rule) {
            if (is_array($rule) && isset($rule[0], $rule[1])) {
                if ($rule[1] == 'required') {
                    $result = static::handleRequiredFilter($result, $rule[0]);
                } else {
                    $result = static::handleTypeFilter($result, $rule[0], $rule[1]);
                }
            }
        }

        return $result;
    }

    /**
     * Remove not required and null values from output.
     *
     * @param array $data
     * @param array $requiredAttributes
     *
     * @return mixed
     */
    private static function handleRequiredFilter($data, $requiredAttributes)
    {
        foreach ($data as $parameterName => $value) {
            if ($value === null && !in_array($parameterName, (array)$requiredAttributes)) {
                unset($data[$parameterName]);
            }
        }

        return $data;
    }

    /**
     * Convert output keys to specific type
     *
     * @param array  $data
     * @param array  $keys keys that need to convert
     * @param string $type
     *
     * @return mixed
     */
    private static function handleTypeFilter($data, $keys, $type)
    {
        foreach ((array)$keys as $key) {
            if (array_key_exists($key, $data)) {
                switch ($type) {
                    case 'boolean':
                        $data[$key] = (boolean)$data[$key];

                        break;
                    case 'integer':
                        $data[$key] = (int)$data[$key];

                        break;
                    default:
                        break;
                }
            }
        }

        return $data;
    }
}