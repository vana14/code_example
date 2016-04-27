<?php

namespace app\base;

class Exception extends \yii\base\Exception
{
    protected $code = 500;

    /**
     * @param int $codeNum
     *
     * @return array
     */
    public function getDataForApi($codeNum)
    {
        $result = [
            'message' => $this->getMessage(),
            'code'    => $codeNum ?: $this->getCode(),
        ];

        if (YII_DEBUG) {
            $result['verbose'] = [
                'file'  => $this->getFile(),
                'line'  => $this->getLine(),
                'trace' => $this->getTraceAsString(),
            ];
        }

        return $result;
    }
}