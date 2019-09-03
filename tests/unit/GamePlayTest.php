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
        $this->assertEquals(19, $this->tester->board[0][0]); // there is a rook oerthere if it is :)
        $this->assertEquals('b1', $this->tester->from);
        $this->assertEquals('b3', $this->tester->to);
    }
}
