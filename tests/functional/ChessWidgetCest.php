<?php


class ChessWidgetCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage(['chess/default/index']);
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function tryToTestViewChess(FunctionalTester $I)
    {
        $I->see('Chess v1.0.0', 'p');
    }
}
