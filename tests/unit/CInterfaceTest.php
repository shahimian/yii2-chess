<?php

namespace shahimian\chess\tests\unit;

use shahimian\chess\components\CInterface;

class CInterfaceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        $this->tester = \Yii::createObject([
            'class' => CInterface::className(),
        ]);
    }

    protected function _after()
    {
    }

    /**
     * @dataProvider additionProvider
     */
    public function testCell($x, $y, $rate, $expected)
    {
        $cell = $this->tester->cell($x, $y, $rate);
        $this->assertEquals($expected, $cell);
    }

    public function additionProvider(){
        return [
            [23, 447, 1, ['row' => 0, 'column' => 0]],
            [450, 210, 1, ['row' => 4, 'column' => 7]],
            [200, 154, 1, ['row' => 5, 'column' => 3]],
            [425, 55, 1, ['row' => 7, 'column' => 7]],
        ];
    }

}