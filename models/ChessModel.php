<?php

namespace shahimian\chess\models;

use yii\base\Model;

class ChessModel extends Model {
    public $phrase;
    public function rules(){
        return [
            [['phrase'], 'required', 'message' => 'Please enter a phrase'],
        ];
    }
}
