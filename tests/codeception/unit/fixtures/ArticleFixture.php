<?php

namespace app\tests\codeception\unit\fixtures;

use yii\test\ActiveFixture;

/**
 * Class ArticleFixture
 * @package app\tests\codeception\unit\fixtures
 */
class ArticleFixture extends ActiveFixture
{
    public $tableName = 'articles';

    public function unload()
    {
        $this->resetTable();
        parent::unload();
    }
}