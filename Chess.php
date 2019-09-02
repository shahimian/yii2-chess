<?php

namespace shahimian\chess;

use Yii;
use yii\base\Widget;

class Chess extends Widget {

    public function run(){
        return $this->render('index');
    }

}
