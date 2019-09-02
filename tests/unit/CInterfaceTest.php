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
    }

    protected function _after()
    {
    }

    public function testSomeFeature()
    {
        $this->tester = \Yii::createObject([
            'class' => CInterface::className(),
        ]);
        $this->assertTrue($this->tester->cell());
    }
}