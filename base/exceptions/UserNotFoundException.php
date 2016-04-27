<?php

namespace app\base\exceptions;

use yii\base\Exception;

class UserNotFoundException extends Exception
{
    protected $code = 404;
}