<?php

namespace app\base\exceptions;

use app\base\Exception;

/**
 * Class NotImplementedException
 * @package app\base\exceptions
 */
class NotImplementedException extends Exception
{
    protected $code = 501;
}