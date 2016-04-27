<?php

namespace app\base\exceptions;

use app\base\Exception;

class UnauthorizedException extends Exception
{
    protected $code = 401;
}