<?php
namespace app\base\exceptions;

use Yii;
use yii\web\ErrorAction;
use yii\web\HttpException;

class CustomErrorAction extends ErrorAction
{
    public function run()
    {
        $exception = Yii::$app->errorHandler->exception;
        if (Yii::$app->request->isAjax) {
            if ($exception !== null && $exception instanceof HttpException) {
                return json_encode([$exception->statusCode => $exception->getMessage()]);
            }
            return json_encode(['500' => 'Произошла ошибка на сервере']);
        }

        $model = array('exception' => $exception);

        if ($exception !== null && $exception instanceof HttpException) {
            if ($exception->statusCode == 404) {
                return $this->controller->render('404.twig', $model);
            }
            if ($exception->statusCode == 400) {
                return $this->controller->render('400.twig', $model);
            }
            if ($exception->statusCode == 403) {
                return $this->controller->render('403.twig', $model);
            }
            if ($exception->statusCode == 500) {
                return $this->controller->render('500.twig', $model);
            }
        }

        return $this->controller->render('500.twig', $model);
    }
}