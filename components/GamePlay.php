<?php

namespace shahimian\chess\components;

use yii\base\BaseObject;

class GamePlay extends BaseObject
{
  public $board;
  public $from;
  public $to;

  public function __construct($config = [])
  {
    parent::__construct($config);
  }

  public function change_man($man_id, $q)
  {
    if($this->board[$this->from['row']][$this->from['column']] == 0)
        return false;
    $this->board[$this->to['row']][$this->to['column']] = $q*$man_id;
    return $this->board;
  }

}
