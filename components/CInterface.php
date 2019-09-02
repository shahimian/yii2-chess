<?php

namespace shahimian\chess\components;

use yii\base\BaseObject;

class CInterface extends BaseObject
{

	public function __construct($config = []){
		parent::__construct($config);
    }
    
    public function cell(){
        return true;
    }

}