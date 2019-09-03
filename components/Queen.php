<?php

namespace shahimian\chess\components;

use shahimian\chess\components\ManValidate;

class Queen extends ManValidate
{

  function __construct($config = [])
  {
    parent::__construct($config);
  }

  function action()
  {
    $flag = false;
    if($this->move() == true &&
        ($this->is_columnar_move() == true ||
        $this->is_row_move() == true) ||
        $this->is_diogonal_move() == true)
    {
      if($this->is_attack())
      {
        $status = 'x';
        $flag = true;
      }
      if($this->opponent_id() == 0)
      {
        $status = '-';
        $flag = true;
      }
    }
    if($flag == true)
    {
      return array('man'=>'D', 'status'=>$status);
    }
    return false;
  }

}