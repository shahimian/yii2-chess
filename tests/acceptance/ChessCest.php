<?php

use yii\helpers\Url;

class ChessCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('chess'));
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function tryToTest(AcceptanceTester $I)
    {
        $I->see("Chess v1.0.0", "p");
    }
}
