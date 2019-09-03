<?php

namespace shahimian\chess\components;

use shahimian\chess\components\ManValidate;

class King extends ManValidate {

  function __construct($config = [])
  {
    parent::__construct($config);
  }

  function action()
  {
    $flag = false;
    $special = 0;
    if($this->is_king_move() == true)
    {
      $dc = abs($this->from['column']-$this->to['column']);
      if($dc == 2)
      {
        $status = '-';    // king side
        $special = 'O.O';
        $flag = true;
        if($this->to['column'] == 2)    // queen side
          $special = 'O.O.O';
      }
      else
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
    }
    if($flag == true)
    {
      return array('man'=>'R', 'status'=>$status, 'special'=>$special);
    }
    return false;
  }

  function is_king_move()
  {
    $dr = abs($this->from['row']-$this->to['row']);
    $dc = abs($this->from['column']-$this->to['column']);
    $color = $this->q > 0 ? 'white' : 'black';
    if(!strcmp($this->board['flag']['go_rook'][$color][9],'true') &&
        $dr == 0 && $dc == 2)
    {
      $rook = 19;       // queen side
      $i = 1;
      $a = true;
      while($i <= 3)
      {
        if($this->board[$this->from['row']][$i] != 0)
        {
          $a = false;
          $break;
        }
        $i += 1;
      }
      if($this->to['column'] == 6)
      {
        $rook = 20;
        $i = 5;
        $a = true;
        while($i <= 6)
        {
          if($this->board[$this->from['row']][$i] != 0)
          {
            $a = false;
            $break;
          }
          $i += 1;
        }
      }

      if(!strcmp($this->board['flag']['go_rook'][$color][$rook],'true') && $a == true)
      {
        $this->board['flag'][$color][19] = false;
        $this->board['flag'][$color][20] = false;
        $this->board['flag'][$color][9] = false;
        return true;
      }
    }
    else
    {
      $w = $dr == 1;
      $x = $dc == 1;
      $y = $dc == 0;
      $z = $dr == 0;
      return (($w && $x) xor ($w && $y)) xor ($x && $z);
    }
  }

}