<?php

namespace app\tests\codeception\api;

use ApiTester;
use app\tests\codeception\unit\fixtures\ArticleFixture;
use yii\codeception\DbTestCase;

class ArticleTest extends DbTestCase
{
    /**
     * @var ApiTester
     */
    protected $I;

    public function _before()
    {
        $this->I = new ApiTester($this->getScenario());
        $this->I->haveHttpHeader('Accept', 'application/json');
    }

    public function _after()
    {
        $this->articles->unload();
    }

    public function fixtures()
    {
        return [
            'articles' => ArticleFixture::className(),
        ];
    }

    public function testAddArticle()
    {
        $data = [
            'title'       => 'Название статьи1',
            'description' => 'Описание1',
        ];
        
        $this->I->wantTo('check that can create article');
        $this->I->sendPOST('/test/articles', $data);

        $this->seeCorrectJsonResponseCode(201);
        $this->I->seeResponseContainsJson(['title' => $data['title']]);
        $this->I->seeResponseContainsJson(['alias' => $data['alias']]);
    }

    public function testUpdateArticle()
    {
        $data = [
            'title'       => 'Название статьи2',
            'description' => 'Описание2',
        ];

        $this->I->wantTo('check that can update article');
        $this->I->sendPUT('/test/articles/' . $this->articles[0]['id'], $data);

        $this->seeCorrectJsonResponseCode(200);
        $this->I->seeResponseContainsJson(['title' => $data['title']]);
        $this->I->seeResponseContainsJson(['alias' => $data['alias']]);
    }

    public function testCheckUpdateNonExistenArticle()
    {
        $this->I->wantTo('check that can\'t update not existing article');
        $this->I->sendPUT('/test/articles/100500', [
            'title' => 'test article',
        ]);
        $this->seeCorrectJsonResponseCode(404, false);
    }

    public function testCheckViewArticle()
    {
        $this->I->wantTo('check that can view article');
        $this->I->sendGET('/test/articles/' . $this->articles[0]['id']);
        $this->seeCorrectJsonResponseCode();
        $this->I->seeResponseContainsJson(['title' => $this->articles[0]['title']]);
        $this->I->seeResponseContainsJson(['description' => $this->articles[0]['description']]);
    }

    public function testCheckViewListArticle()
    {
        $this->I->wantTo('check that can view list article');
        $this->I->sendGET('/test/articles');
        $this->seeCorrectJsonResponseCode();

        assertTrue(count(json_decode($this->I->grabResponse(), 1)));
    }

    public function testCheckDeleteArticle()
    {
        $this->I->wantTo('check that can delete article');
        $this->I->sendDELETE('/test/articles/' . $this->articles[0]['id']);
        $this->seeCorrectJsonResponseCode(204, false);
    }

    public function testCheckDeleteNonexistentArticle()
    {
        $this->I->wantTo('check that can\'t delete nonexistent article');
        $this->I->sendDELETE('/test/articles/100500');
        $this->seeCorrectJsonResponseCode(404, false);
    }
    
    private function seeCorrectJsonResponseCode($responseCode = 200, $needSwaggerDefinition = true)
    {
        $this->I->seeResponseCodeIs($responseCode);
        $this->I->seeResponseIsJson();

        if ($needSwaggerDefinition) {
            $this->I->seeThatResponseIsMatchedSwaggerDefinition();
        }
    }
}