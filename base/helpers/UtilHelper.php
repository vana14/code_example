<?php

namespace app\base\helpers;

/**
 * Class UtilHelper
 * @package app\base\helpers
 */
class UtilHelper
{
    /**
     * @param array $array
     * @param bool  $recursive
     *
     * @return array
     */
    public static function arrayKeysCamelize(array $array, $recursive = true)
    {
        $newArray = [];

        foreach ($array as $key => $value) {
            $newKey = static::camelize($key);

            if ($recursive && is_array($value)) {
                $newArray[$newKey] = static::arrayKeysCamelize($value, true);
            } else {
                $newArray[$newKey] = $value;
            }
        }

        return $newArray;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function camelize($string)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $string))));
    }
}