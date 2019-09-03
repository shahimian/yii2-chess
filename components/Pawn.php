<?php

namespace shahimian\chess\components;

use shahimian\chess\components\ManValidate;

class Pawn extends ManValidate
{

  function __construct($config = [])
  {
    parent::__construct($config);
  }

  function action()
  {
    $flag = false;
    $status = '-';
    $move_row = abs($this->from['row']-$this->to['row']);
    $move_col = abs($this->from['column']-$this->to['column']);
    $which_id = $this->opponent_id() > 0 ? 1 : -1;
    $special = 0;

    if($this->move_single_cell($move_row,$move_col) xor $this->move_two_cells($move_row,$move_col))
      $flag = true;

    // attack
    elseif($move_row == 1 && $move_col == 1 && $this->is_attack())
    {
      $flag = true;
      $status = 'x';
    }

    // e.p.
    else
    {
      $col_side = $this->to['row']-$this->q;
      $id_side = $this->board[$col_side][$this->to['column']];
      $which_id_side = $id_side > 0 ? 1 : -1;
      $which_color = $id_side > 0 ? 'white' : 'black';
      $row_ep = $id_side > 0 ? 3 : 4;
      $status = 'x';
      $special = 'e.p.';
      if($this->opponent_id() == 0 && $which_id_side != $this->q
          && abs($id_side) >= 1 && abs($id_side) <= 8 //pawn
          && !strcmp($this->board['flag']['ep'][$which_color][abs($id_side)],'true')
          && $this->from['row'] == $row_ep)
      {
        $flag = true;
      }
    }

    if($flag)
      return array('man'=>'P', 'status'=>$status, 'special'=>$special);

    return false;
  }

  function move_single_cell($move_row, $move_col)
  {
    return (($this->q > 0 && ($this->from['row'] < $this->to['row'])) ||
        ($this->q < 0 && ($this->from['row'] > $this->to['row']))) &&
        $move_row == 1 && $move_col == 0;
  }

  function move_two_cells($move_row, $move_col)
  {

    $color = $this->q > 0 ? 'white' : 'black';
    $man_id = abs($this->board[$this->from['row']][$this->from['column']]);

    return (($this->q > 0 && ($this->from['row'] < $this->to['row'])) ||
        ($this->q < 0 && ($this->from['row'] > $this->to['row']))) &&
        $move_row == 2 && $move_col == 0 &&
        !strcmp($this->board['flag']['start_pawn'][$color][$man_id],'true');

  }

}