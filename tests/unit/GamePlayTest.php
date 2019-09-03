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
            'from' => [
                'row' => 1,
                'column' => 0,
            ],
            'to' => [
                'row' => 3,
                'column' => 0,
            ],
        ]);
    }

    public function testPropertiesGamePlay()
    {
        $this->assertEquals(19, $this->tester->board[0][0]); // there is a rook oerthere if it is :)
        $this->assertEquals([
            'row' => 1,
            'column' => 0,
        ], $this->tester->from);
        $this->assertEquals([
            'row' => 3,
            'column' => 0,
        ], $this->tester->to);
    }

    public function testErrorChangeMan(){
        $this->tester->from = [
            'row' => 2,
            'column' => 0,
        ];
        $this->assertFalse($this->tester->change_man(1, 1));
    }

    public function testChangeMan(){
        $this->tester->from = [
            'row' => 1,
            'column' => 0,
        ];
        $this->tester->to = [
            'row' => 3,
            'column' => 0,
        ];
        $this->tester->change_man(1, 1);
        $this->assertEquals(1, $this->tester->board[3][0]);
    }

}
