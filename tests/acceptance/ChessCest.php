<?php

use shahimian\chess\Chess;

class ChessCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(['chess/default/index']);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function tryToTest(AcceptanceTester $I)
    {
        $I->see("Chess v1.0.0", "p");
    }
}
