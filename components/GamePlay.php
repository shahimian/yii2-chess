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

  function is_ep($man_id)
  {

    $this->all_ep_false();

    if($this->is_pawn($man_id) == true)
    {
      $which = $this->which($man_id);
      $color = $this->color($man_id);
      if(($which == 1 && $this->to['pos1']['row'] == 3) || ($which == -1 && $this->to['pos1']['row'] == 4))
      {
        $this->board['flag']['ep'][$color][abs($man_id)] = true;
      }
    }
  }

  function attack_ep($man_id)
  {
    if(abs($man_id) >= 1 && abs($man_id) <= 8)
    {
      $q = $man_id > 0 ? 1 : -1;
      $col_side = $this->to['pos1']['row']-$q;
      $id_side = $this->board[$col_side][$this->to['pos1']['column']];
      $which_color = $id_side > 0 ? 'white' : 'black';
      $move_row = abs($this->from['pos1']['row']-$this->to['pos1']['row']);
      $move_col = abs($this->from['pos1']['column']-$this->to['pos1']['column']);
      if($move_row == 1 && $move_col == 1
          && abs($id_side) >= 1 && abs($id_side) <= 8 //pawn
          && strcmp($this->board['flag']['ep'][$which_color][abs($id_side)],'true') == 0)
      {
        $this->board[$col_side][$this->to['pos1']['column']] = 0;
      }
    }
  }

  function start_move_pawn($man_id)
  {
    $move = abs($this->from['pos1']['row'] - $this->to['pos1']['row']);
    $color = $this->color($man_id);
    if($this->from['pos1']['row'] == 1 || $this->from['pos1']['row'] == 6)
    {
      $this->board['flag']['start_pawn'][$color][abs($man_id)] = false;
    }
  }

  function is_pawn($man_id)
  {
    return abs($man_id) >= 1 && abs($man_id) <= 8;
  }

  function color($man_id)
  {
    return ($man_id > 0 ? 'white' : 'black');
  }

  function which($man_id)
  {
    return ($man_id > 0 ? 1 : -1);
  }

  function all_ep_false()
  {
    for($i=1; $i<=8; $i++)
    {
      $this->board['flag']['ep']['white'][$i] = false;
      $this->board['flag']['ep']['black'][$i] = false;
    }
  }

  function go_rook()
  {
    $man_id = $this->board[$this->to['pos1']['row']][$this->to['pos1']['column']];
    if(abs($man_id) == 19 || abs($man_id) == 20 || abs($man_id) == 9)
    {
      $color = $man_id > 0 ? 'white' : 'black';
      if(abs($man_id) == 9)
      {
        $this->board['flag']['go_rook'][$color][19] = false;
        $this->board['flag']['go_rook'][$color][20] = false;
        $this->board['flag']['go_rook'][$color][9] = false;
      }
      $this->board['flag']['go_rook'][$color][abs($man_id)] = false;
    }
    return $this->board;
  }

  function change_board()
  {
    $i = 1;
    while($i <= 2)
    {
      if($i == 2 && (!isset($this->from['pos2']['row']) || $this->from['pos2']['row'] == -1))
      {
        $i += 1;
      }
      else
      {
        $man_id = $this->board[$this->from['pos' . $i]['row']][$this->from['pos' . $i]['column']];
        $this->board[$this->from['pos' . $i]['row']][$this->from['pos' . $i]['column']] = 0;
        $this->board[$this->to['pos' . $i]['row']][$this->to['pos' . $i]['column']] = $man_id;
        $this->go_rook();
        $i += 1;
      }
    }
    $this->attack_ep($man_id);
    $this->is_ep($man_id);
    $this->start_move_pawn($man_id);
    return $this->board;
  }


}
