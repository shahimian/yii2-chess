<?php

class GamePlayTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        $cb = \Yii::createObject([
            'class' => \shahimian\chess\components\ChessBoard::className(),
        ]);
        $this->tester = \Yii::createObject([
            'class' => \shahimian\chess\components\GamePlay::className(),
            'board' => $cb->board,
            'from' => 'b1',
            'to' => 'b3',
        ]);
    }

    public function testPropertiesGamePlay()
    {
        $this->assertEquals('b1', $this->tester->from);
        $this->assertEquals('b3', $this->tester->to);
    }
}
