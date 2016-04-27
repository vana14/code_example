<?php
/**
 * Created by PhpStorm.
 * User: vlaptev
 * Date: 18.08.15
 */

namespace app\base\behaviors;

use Closure;
use yii\base\Behavior;
use yii\base\Event;

/**
 * AttributeFilterBehavior automatically filter value to one or multiple attributes of an ActiveRecord
 * object when certain events happen.
 *
 * To use AttributeFilterBehavior, configure the [[attributes]] property which should specify the list of attributes
 * that need to be updated and the corresponding events that should trigger the update. Then configure the
 * [[filter]] property with a PHP callable whose return value will be used to assign to the current attribute(s).
 *
 * Class AttributeFilterBehavior
 * @package app\base\behaviors
 */
class AttributeFilterBehavior extends Behavior
{
    /**
     * @var array list of attributes that are to be automatically filled with the value specified via [[value]].
     * The array keys are the ActiveRecord events upon which the attributes are to be updated,
     * and the array values are the corresponding attribute(s) to be updated. You can use a string to represent
     * a single attribute, or an array to represent a list of attributes. For example,
     *
     * ```php
     * [
     *     ActiveRecord::EVENT_BEFORE_INSERT => ['attribute1', 'attribute2'],
     *     ActiveRecord::EVENT_BEFORE_UPDATE => 'attribute2',
     * ]
     * ```
     */
    public $attributes = [];

    /**
     * @var mixed the value that will be assigned to the current attributes. This can be an anonymous function
     * or an arbitrary value. If the former, the return value of the function will be assigned to the attributes.
     * The signature of the function should be as follows,
     *
     * ```php
     * function ($value)
     * {
     *     // return value will be assigned to the attribute
     * }
     * ```
     */
    public $filter;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return array_fill_keys(array_keys($this->attributes), 'filterAttributes');
    }

    /**
     * Filter the attribute value and assigns it to the current attributes.
     *
     * @param Event $event
     */
    public function filterAttributes($event)
    {
        if (!empty($this->attributes[$event->name])) {
            $eventAttributes = (array)$this->attributes[$event->name];

            foreach ($eventAttributes as $attribute) {
                // ignore attribute names which are not string (e.g. when set by TimestampBehavior::updatedAtAttribute)
                if (is_string($attribute) && $this->owner->$attribute) {
                    $this->owner->$attribute = $this->getValue($this->owner->$attribute);
                }
            }
        }
    }

    /**
     * Returns the value of the current attributes.
     * This method is called by [[filterAttributes()]]. Its return value will be assigned
     * to the attributes corresponding to the triggering event.
     *
     * @param mixed $attributeValue
     *
     * @return mixed the attribute value
     */
    protected function getValue($attributeValue)
    {
        return $this->filter instanceof Closure ? call_user_func($this->filter, $attributeValue) : $this->filter;
    }
}