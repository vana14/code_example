<?php

namespace app\modules\test\controllers;

use app\base\controllers\ActiveController;
use app\modules\test\models\Article;
use Yii;

/**
 * Class ArticlesController
 * @package app\modules\test\controllers
 */
class ArticlesController extends ActiveController
{
    public $modelClass = Article::class;
}