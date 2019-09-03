<?php

namespace shahimian\chess\components;

use yii\base\BaseObject;

class GamePlay extends BaseObject
{
  public $board;
  public $from;
  public $to;

  function __construct($config = [])
  {
    parent::__construct($config);
  }

}
