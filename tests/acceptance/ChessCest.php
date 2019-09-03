<?php

use yii\helpers\Url;

class ChessCest
{
    public function tryToViewChess(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/chess'));
        $I->see("Chess v1.0.0", "p");
    }
}
