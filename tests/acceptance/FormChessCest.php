<?php

use yii\helpers\Url;

class FormChessCest
{
    public function tryToSeeWhatValuesAre(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/chess/default/form'));
        $I->see('Form Movement', 'h1');
        $I->submitForm('#chess-form', []);
        $I->submitForm('#chess-form', [
            'ChessModel[phrase]' => 'a2-h3',
        ]);
    }
}
