<?php

use yii\helpers\Url;

class ViewCest
{
    public function tryMovementMan(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/chess'));
        $I->seeElement('div');
        $I->submitForm('#chess-form');
        $I->see('Please enter a phrase', '')
    }
}
