<?php

namespace app\base\exceptions;

use app\base\Exception;

class BadMethodCallException extends Exception
{
    protected $code = 400;
}