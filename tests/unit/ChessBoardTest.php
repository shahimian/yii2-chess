<?php

class ChessBoardTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        $this->tester = \Yii::createObject([
            'class' => \shahimian\chess\components\ChessBoard::className(),
        ]);
    }

    /**
     * @dataProvider additionProviderBoardMan
     */
    public function testBoard($row, $column, $expected)
    {
        $this->assertEquals($expected, $this->tester->board[$row][$column]);
    }

    public function additionProviderBoardMan(){
        return [
            /* rooks */
            [0, 0, 19],
            [0, 7, 20],
            [7, 0, -19],
            [7, 7, -20],
            /* knight */
            [0, 1, 29],
            [0, 6, 30],
        ];
    }

}