<?php

namespace shahimian\chess\components;

use shahimian\chess\components\ManValidate;

class Check extends ManValidate
{

  public $board;
  public $man_id;
  public $route = array();

  function __construct($config = [])
  {
    parent::__construct($config);
  }

  function where_king($q)
  {
    $i = 0;
    foreach($this->board as $row)
    {
      $j = 0;
      foreach($row as $x)
      {
        if(($q > 0 && $x > 0 || $q < 0 && $x < 0) && abs($x) == 9)
		{
            return array('row'=>$i, 'column'=>$j);
		}
        $j += 1;
      }
      $i += 1;
    }
  }
    
  function check($q, $cell)
  {
	return $this->pawn_move($q, $cell['row'], $cell['column']) ||
		$this->columnar_row_move($q, $cell['row'], $cell['column']) ||
		$this->diogonal_move($q, $cell['row'], $cell['column']) ||
		$this->knight_move($q, $cell['row'], $cell['column']);
  }
  
  function pass($special,$q)
  {
    $row = $q > 0 ? 0 : 7;
	$pos = $this->where_king($q);
    if(!strcmp($special,'O.O'))
    {
      $this->board[$row][4]=0;
      $this->board[$row][5]=$q*9;
      return (!$this->check($q,$pos) ? true : false);
    }
    elseif(!strcmp($special,'O.O.O'))
    {
      $this->board[$row][4]=0;
      $this->board[$row][3]=$q*9;
      if(!$this->check($q,$pos))
      {
        $this->board[$row][3]=0;
        $this->board[$row][2]=$q*9;
        return (!$this->check($q,$pos)? true : false);
      }
    }
    return false;
  }

  function pawn_move($q, $row, $col)
  {

    return $this->is_pawn_opp($row-1,$col-1,$q,'P') ||
      $this->is_pawn_opp($row-1,$col+1,$q,'P') ||
      $this->is_pawn_opp($row+1,$col-1,$q,'P') ||
      $this->is_pawn_opp($row+1,$col+1,$q,'P');

  }

  function is_pawn_opp($row,$col,$q,$sign)
  {

    if($col < 0 || $col > 7 || $row < 0 || $row > 7)
        return false;

    $man = $this->board[$row][$col];
    $this->man_id = $man;
    return !strcmp($this->man($man),$sign) && ($q > 0 && $man < 0 || $q < 0 && $man > 0);

  }

  function columnar_row_move($q, $row, $col)
  {

    $flag = false;

    $this->route = array();
    $count = 0;
    $max_count = 0;

    // right
    $j = $col + 1;
    while($j <= 7 && !$flag)
    {
      $man = $this->man(abs($this->board[$row][$j]));
      if($this->is_opponent($row,$j,$man,'T',$q) || $this->is_opponent($row,$j,$man,'D',$q))
          $flag = true;
      elseif($this->board[$row][$j] == 0)
      {
        array_push($this->route, array('row'=>$row, 'column'=>$j));
        $j += 1;
      }
      else
        $j = 8;
    }

    // top
    $i = $row + 1;
    while($i <= 7 && !$flag)
    {
      $man = $this->man(abs($this->board[$i][$col]));
      if($this->is_opponent($i,$col,$man,'T',$q) || $this->is_opponent($i,$col,$man,'D',$q))
          $flag = true;
      elseif($this->board[$i][$col] == 0)
      {
        array_push($this->route, array('row'=>$i, 'column'=>$col));
        $max_count += 1;
        $i += 1;
      }
      else
        $i = 8;
    }

    // left
    $j = $col - 1;
    while($j >= 0 && !$flag)
    {
      $man = $this->man(abs($this->board[$row][$j]));
      if($this->is_opponent($row,$j,$man,'T',$q) || $this->is_opponent($row,$j,$man,'D',$q))
          $flag = true;
      elseif($this->board[$row][$j] == 0)
      {
        array_push($this->route, array('row'=>$row, 'column'=>$j));
        $j -= 1;
      }
      else
        $j = -1;
    }

    // bottom
    $i = $row - 1;
    while($i >= 0 && !$flag)
    {
      $man = $this->man(abs($this->board[$i][$col]));
      if($this->is_opponent($i,$col,$man,'T',$q) || $this->is_opponent($i,$col,$man,'D',$q))
          $flag = true;
      elseif($this->board[$i][$col] == 0)
      {
        array_push($this->route, array('row'=>$i, 'column'=>$col));
        $i -= 1;
      }
      else
        $i = -1;
    }

    return $flag;

  }

  function diogonal_move($q, $row, $col)
  {

    $flag = false;

    // right top
    $this->route = array();
    $i = $row + 1;
    $j = $col + 1;
    while(($i <= 7 && $j <= 7) && !$flag)
    {
      $man = $this->man(abs($this->board[$i][$j]));
      if($this->is_opponent($i,$j,$man,'F',$q) || $this->is_opponent($i,$j,$man,'D',$q))
          $flag = true;
      elseif($this->board[$i][$j] == 0)
      {
        array_push($this->route, array('row'=>$i, 'column'=>$j));
        $i += 1;
        $j += 1;
      }
      else
      {
        $i = 8;
        $j = 8;
      }
    }

    // left top
    $i = $row + 1;
    $j = $col - 1;
    while(($i <= 7 && $j >= 0) && !$flag)
    {
      $man = $this->man(abs($this->board[$i][$j]));
      if($this->is_opponent($i,$j,$man,'F',$q) || $this->is_opponent($i,$j,$man,'D',$q))
          $flag = true;
      elseif($this->board[$i][$j] == 0)
      {
        array_push($this->route, array('row'=>$i, 'column'=>$j));
        $i += 1;
        $j -= 1;
      }
      else
      {
        $i = 8;
        $j = -1;
      }
    }

    // left bottom
    $i = $row - 1;
    $j = $col - 1;
    while(($i >= 0 && $j >= 0) && !$flag)
    {
      $man = $this->man(abs($this->board[$i][$j]));
      if($this->is_opponent($i,$j,$man,'F',$q) || $this->is_opponent($i,$j,$man,'D',$q))
          $flag = true;
      elseif($this->board[$i][$j] == 0)
      {
        array_push($this->route, array('row'=>$i, 'column'=>$j));
        $i -= 1;
        $j -= 1;
      }
      else
      {
        $i = -1;
        $j = -1;
      }
    }

    // right bottom
    $this->route = array();
    $i = $row - 1;
    $j = $col + 1;
    while(($i >= 0 && $j <= 7) && !$flag)
    {
      $man = $this->man(abs($this->board[$i][$j]));
      if($this->is_opponent($i,$j,$man,'F',$q) || $this->is_opponent($i,$j,$man,'D',$q))
          $flag = true;
      elseif($this->board[$i][$j] == 0)
      {
        array_push($this->route, array('row'=>$i, 'column'=>$j));
        $i -= 1;
        $j += 1;
      }
      else
      {
        $i = -1;
        $j = 8;
      }
    }

    return $flag;

  }

  function knight_move($q, $row, $col)
  {

    return $this->is_knight_opp($row-1,$col-2,$q) ||
        $this->is_knight_opp($row-1,$col+2,$q) ||
        $this->is_knight_opp($row+1,$col-2,$q) ||
        $this->is_knight_opp($row+1,$col+2,$q) ||
        $this->is_knight_opp($row-2,$col-1,$q) ||
        $this->is_knight_opp($row-2,$col+1,$q) ||
        $this->is_knight_opp($row+2,$col-1,$q) ||
        $this->is_knight_opp($row+2,$col+1,$q);
  }

  function is_knight_opp($row,$col,$q)
  {
    if($col < 0 || $col > 7 || $row < 0 || $row > 7)
        return false;
    $man = $this->board[$row][$col];
    return !strcmp($this->man($man),'C') && ($q > 0 && $man < 0 || $q < 0 && $man > 0);
  }
  
  function king_move($q, $row, $column)
  {
	$flag = false;
	$cell = array('row'=>$row, 'column'=>$column);
	$lm = array(array(0, 1), array(1, 1), array(1, 0), array(1, -1),
		array(0, -1), array(-1, -1), array(-1, 0), array(-1, 1));
	foreach($lm as $c)
	{
		$tmp = $cell;
		$tmp['row'] += $c[0];
		$tmp['column'] += $c[1];
		$flag |= $this->is_pawn_opp($tmp['row'],$tmp['column'],$q,'R');
	}
	return $flag;
  }
  
  function in_board($cell)
  {
	return ($cell['column'] >= 0 && $cell['column'] <= 7) && ($cell['row'] >= 0 && $cell['row'] <= 7);
  }
  
  function is_empty($cell)
  {
	return $this->board[$cell['row']][$cell['column']] == 0;
  }
  
  function is_opponent($row,$col,$man,$sign,$q)
  {
    $flag = ($this->board[$row][$col] != 0 &&			// exist any man
        ($q > 0 && $this->board[$row][$col] < 0) ||		// a man against to another man
        $q < 0 && $this->board[$row][$col] > 0) &&		
        !strcmp($man,$sign);
    if($flag)
    {
      $from_opp = array('row'=>$row, 'column'=>$col);
      $this->man_id = $this->board[$from_opp['row']][$from_opp['column']];
    }
    return $flag;
  }

}