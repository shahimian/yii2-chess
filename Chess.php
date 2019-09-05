<?php

namespace shahimian\chess;

use Yii;
use yii\base\Widget;

class Chess extends Widget {

    public $phrase;
    public $script = [];

    public function init(){
        parent::init();
        array_push($this->script, $this->phrase);
    }

    public function phrase($phrase){
        array_push($this->script, $phrase);
    }

    public function view(){
        return $this->render('index', [
            'movements' => $this->movementMan(),
        ]);
    }

    private function movementMan(){
        return [
            'wp-1' => [
                'x' => 0,
                'y' => -50,
            ],
            'bp-4' => [
                'x' => 0,
                'y' => 100,
            ],
        ];
    }

}
