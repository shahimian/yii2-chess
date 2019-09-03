<?php

class ManValidateTest extends \Codeception\Test\Unit
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
            'class' => \shahimian\chess\components\ManValidate::className(),
            'board' => $cb->board,
            'q' => 1,
        ]);
    }

    public function testSomeFeature()
    {
        $this->assertEquals(1, $this->tester->q);        
    }
}