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
     * @dataProvider additionProviderCell
     */
    public function testCell($x, $y, $rate, $expected)
    {
        $cell = $this->tester->cell($x, $y, $rate);
        $this->assertEquals($expected, $cell);
    }

    public function additionProviderCell(){
        return [
            [23, 447, 1, ['row' => 0, 'column' => 0]],
            [450, 210, 1, ['row' => 4, 'column' => 7]],
            [200, 154, 1, ['row' => 5, 'column' => 3]],
            [425, 55, 1, ['row' => 7, 'column' => 7]],
        ];
    }

    /**
     * @dataProvider additionProviderConvert
     */
    public function testConvert($cell, $expected){
        $convert = $this->tester->convert($cell);
        $this->assertEquals($expected, $convert);
    }

    public function additionProviderConvert(){
        return [
            [['row' => 0, 'column' => 0], ['x' => 420, 'y' => 0]],
            [['row' => 7, 'column' => 7], ['x' => 0, 'y' => 420]],
            [['row' => 5, 'column' => 3], ['x' => 120, 'y' => 180]],
        ];
    }

    /**
     * @dataProvider additionProviderDetermineClass
     */
    public function testDetermineClass($man, $q, $expected){
        $dc = $this->tester->determine_class($man, $q);
        $this->assertEquals($expected, $dc);
    }

    public function additionProviderDetermineClass(){
        return [
            ['a', 1, false],
            ['p', 1, 'white-pawn'],
            ['t', -1, 'black-rook'],
            ['c', -1, 'black-knight'],
        ];
    }

    /**
     * @dataProvider additionProviderMapConvert
     */
    public function testMapConvert($row, $column, $color, $expectedRow, $expectedColumn){
        $mc = $this->tester->map_convert([
            'row' => $row,
            'column' => $column,
        ], $color);
        $this->assertEquals([
            'row' => $expectedRow,
            'column' => $expectedColumn,
        ], $mc);
    }

    public function additionProviderMapConvert(){
        return [
            [0, 0, -1, 7, 7],
            [5, 3, 1, 5, 3],
            [3, 3, -1, 4, 4],
        ];
    }

}
