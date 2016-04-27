<?php

namespace app\base\exceptions;

use app\base\Exception;

/**
 * Class NotAcceptableException
 * @package app\base\exceptions
 */
class NotAcceptableException extends Exception
{
    /**
     * @inheritdoc
     */
    protected $code = 406;

    /**
     * @var array
     */
    protected $data;

    public function __construct($message, array $data)
    {
        parent::__construct($message, $this->code);

        $this->data = $data;
    }

    /**
     * @inheritdoc
     */
    public function getDataForApi($codeNum)
    {
        return $this->data;
    }
}