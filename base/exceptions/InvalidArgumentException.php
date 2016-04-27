<?php

namespace app\base\exceptions;

class InvalidArgumentException extends \InvalidArgumentException
{
    protected $code = 400;
}