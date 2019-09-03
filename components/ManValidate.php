<?php

namespace shahimian\chess\components;

use shahimian\chess\components\GamePlay;

class ManValidate extends GamePlay {
  
    public $q;

    public function __construct($config = []){
        parent::__construct($config);
    }

    function decision()
    {
      $man = $this->man_id();
      if($man != 0 && $man == $this->q*abs($man))
      {
        $man = $this->man($man);
        if($man == 'R')
          $man = new King($this->board, $this->from, $this->to, $this->q);
        elseif($man == 'D')
          $man = new Queen($this->board, $this->from, $this->to, $this->q);
        elseif($man == 'T')
          $man = new Rook($this->board, $this->from, $this->to, $this->q);
        elseif($man == 'F')
          $man = new Bishop($this->board, $this->from, $this->to, $this->q);
        elseif($man == 'C')
          $man = new Knight($this->board, $this->from, $this->to, $this->q);
        else
          $man = new Pawn($this->board, $this->from, $this->to, $this->q);
        $d = $man->action();
        return $d;
      }
      return false;
    }
    
      /*   
      *	are there set of mans in board?
      *	param: mans array
      */
    function exist_mans($mans)
    {
      $route_white = 0;
      $route_black = 0;
      $tmp = array('white'=>array(),'black'=>array());
      for($i = 0; $i < 8; $i++)
          for($j = 0; $j < 8; $j++)
          {
              $cell = $this->board[$i][$j];
              $man = $this->man($cell);
              if(in_array($man, $mans['white']))
                  array_push($tmp['white'], $man);
              if(in_array($this->man($cell), $mans['black']))
                  array_push($tmp['black'], $man);
              if(in_array('F', $mans['white']) && in_array('F', $mans['black']))
              {
                  if($this->color_route_bishop($i, $j, 'white'))
                      $route_white++;
                  if($this->color_route_bishop($i, $j, 'black'))
                      $route_black++;
              }
          }
      if($mans == $tmp)
      {
          if(in_array('F', $mans['white']) && in_array('F', $mans['black']) && ($route_white == 2 || $route_black == 2))
              return true;
          return true;
      }
      return false;
    }
    
    function color_route($row, $col)
    {
      return $row * $col % 2 == 0 ? 'white' : 'black';
    }
    
    function color_route_bishop($row, $col, $color)
    {
      return $this->color_route($row, $col) === $color && $this->man($this->board[$row][$col]) === 'F';
    }
  
    function man($man)
    {
      $man = abs($man);
      switch($man)
      {
        case 9: $str = 'R'; break;
        case $man >= 10 && $man <= 18: $str = 'D'; break;
        case ($man >= 19 && $man <= 28): $str = 'T'; break;
        case ($man >= 29 && $man <= 38): $str = 'C'; break;
        case ($man >= 39 && $man <= 48): $str = 'F'; break;
        default: $str = 'P';
      }
      return $str;
    }
  
    function move()
    {
      if($this->is_columnar_move() == true)               // columnar move
      {
        $i = ($this->from['row'] < $this->to['row']) ? $this->from['row'] + 1 :
          $this->from['row'] - 1;
        $j = $this->to['row'];
        $c = $this->from['column'];
        while(($i <= $j)^($i >= $j))
        {
          if($this->board[$i][$c] == 0)
          {
            $i = ($this->from['row'] < $this->to['row']) ? $i + 1 : $i - 1;
          }
          else
          {
            return false;
          }
        }
        return true;
      }
      elseif($this->is_row_move() == true)                // row move
      {
        $i = ($this->from['column'] < $this->to['column']) ? $this->from['column'] + 1 :
          $this->from['column'] - 1;
        $j = $this->to['column'];
        $r = $this->from['row'];
        while(($i <= $j)^($i >= $j))
        {
          if($this->board[$r][$i] == 0)
          {
            $i = ($this->from['column'] < $this->to['column']) ? $i + 1 : $i - 1;
          }
          else
          {
            return false;
          }
        }
        return true;
      }
      elseif($this->is_diogonal_move() == true)   // diagonol move
      {
        $i = $this->from['row'] > $this->to['row'] ? $i = $this->from['row'] - 1 :
          $this->from['row'] + 1;
        $j = $this->from['column'] > $this->to['column'] ?
          $j = $this->from['column'] - 1 : $this->from['column'] + 1;
        while(($j < $this->to['column'] || $j > $this->to['column']) &&
        (($i <= $this->to['row'])^($i >= $this->to['row'])))
        {
          if($this->board[$i][$j] == 0)
          {
            if($i > $this->to['row']) $i--; else $i++;
            if($j > $this->to['column']) $j--; else $j++;
          }
          else
          {
            return false;
          }
        }
        return true;
      }
      else {
        return false;
      }
    }
  
    function is_attack()
    {
        if($this->opponent_id() != 0 &&
          abs($this->opponent_id()) != 9 &&
          $this->which_id() != $this->q)
        {
          return true;
        }
        return false;
    }
  
    function opponent_id()
    {
      return $this->board[$this->to['row']][$this->to['column']];
    }
  
    function man_id()
    {
      return $this->board[$this->from['row']][$this->from['column']];
    }
  
    function which_id()
    {
      return $this->opponent_id() > 0 ? 1 : -1;
    }
  
    function is_columnar_move()
    {
      return $this->from['column'] == $this->to['column'];
    }
  
    function is_row_move()
    {
      return $this->from['row'] == $this->to['row'];
    }
  
    function is_diogonal_move()
    {
      return (abs($this->from['row'] - $this->to['row']) == abs($this->from['column'] - $this->to['column']));
    }
  
    function max_man_id($man, $q)
    {
      list($min, $max) = $this->range_man_id(strtoupper($man));
      $man_id = $min;
      $i = 0;
      foreach($this->board as $row)
      {
        if($i < 8)
        {
          foreach($row as $x)
          {
            if($x > 0 && $q > 0 && abs($x) > $man_id && ($x >= $min && $x <= $max)) $man_id = abs($x);
            elseif($x < 0 && $q < 0 && abs($x) > $man_id && (abs($x) >= $min && abs($x) <= $max)) $man_id = abs($x);
          }
          $i += 1;
        }
        else break;
      }
      return $man_id;
    }
  
    function range_man_id($man)
    {
      $min = 1;
      $max = 8;
      if(!strcmp($man,'R'))
      {
        $min = 9;
        $max = 9;
      }
      elseif(!strcmp($man,'D'))
      {
        $min = 10;
        $max = 18;
      }
      elseif(!strcmp($man,'T'))
      {
        $min = 19;
        $max = 28;
      }
      elseif(!strcmp($man,'C'))
      {
        $min = 29;
        $max = 38;
      }
      elseif(!strcmp($man,'F'))
      {
        $min = 39;
        $max = 48;
      }
      return array($min, $max);
    }
  
    function validate_syntax($reg)
    {
      $reg = strtolower($reg);
      $pattern = '/^(?<element>p?|[tcfdr]?)(?<from>[a-h][1-8])(?<transfer>[\-x]?)(?<to>[a-h][1-8])$/';
      preg_match($pattern, $reg, $this->transfer);
      if(count($this->transfer))
          return true;
      return false;
    }  

}
