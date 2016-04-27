<?php

namespace app\base\exceptions;

use app\base\Exception;

/**
 * Class ApiException
 * @package app\base\exceptions
 */
class ApiException extends Exception
{
    protected $code = 500;
}