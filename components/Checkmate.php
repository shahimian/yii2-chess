<?php

namespace shahimian\chess\components;

use shahimian\chess\components\Check;

class Checkmate extends Check
{
  public $from;
  public $to;
  public $man_id;
  public $row;
  public $col;

  function __construct($config = [])
  {
    parent::__construct($config);
  }

  function checkmate($q)
  {
    $flag = false;
    $i = 1;
    $tmp = $this->board;
    $from = $this->from;
    $to = $this->to;
    $this->row = $to['row'];
    $this->col = $to['column'];
    $man_id = 0;

    // is a man that attack man checks king?
    while($i <= 4)
    {

      $this->board = $tmp;
      $this->from = $from;
      $this->to = $to;

      switch($i)
      {
        case 1: $this->pawn_move(-$q); break;
        case 2: $this->columnar_row_move(-$q); break;
        case 3: $this->diogonal_move(-$q); break;
        case 4: $this->knight_move(-$q);
      }

      $i += 1;
      // cell that a man attacks another man checks king
      if($this->man_id)
      {

        $this->from = array('pos1'=>$this->from_opp);
        $man_id = $this->man_id;
        $this->to = array('pos1'=>$this->to);
        $this->board = $this->change_board();

        if($this->check($q))
          $flag = true;
        else
        {
          $this->man_id = $man_id;
          return false;
        }

      }
      else
      {
        return false/*!$this->opposition($from, $to, $q)*/;
      }


    }

  }

  /*
  arguments:
    @param Array cell1 cell of man check king
    @param Array cell2 cell of king
    @param Number  q is queue
  Return
    Boolean if a man opposite of man check king is true else false
  */

/*  function opposition($cell1, $cell2, $q)
  {
    $this->check($q);
    $route = $this->route;
    $man_id = $this->board[$cell1['row']][$cell1['column']];
    $flag = false;
    if(count($route))
    {
      $i = 0;
      while($i < count($route) && !$flag)
      {
        $this->board[$cell1['row']][$cell1['column']] = 0;
        $this->board[$route[$i]['row']][$route[$i]['column']] = $man_id;
        if($this->check($q))
        {
           $flag = true;
        }
        $i += 1;
      }
    }
    return $flag;
  }
*/
}