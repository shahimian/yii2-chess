<?php

namespace shahimian\chess\components;

use shahimian\chess\components\ManValidate;

class Knight extends ManValidate
{

  function __construct($config = [])
  {
    parent::__construct($config = []);
  }

  function action()
  {
    $flag = false;
    if($this->is_knight_move() == true)
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
      return array('man'=>'C', 'status'=>$status);
    }
    return false;
  }

  function is_knight_move()
  {
    $dis_row = abs($this->from['row'] - $this->to['row']);
    $dis_col = abs($this->from['column'] - $this->to['column']);
    return (($dis_row == 2 && $dis_col == 1) || ($dis_row == 1 && $dis_col == 2));
  }

}