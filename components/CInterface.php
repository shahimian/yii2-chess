<?php

namespace shahimian\chess\components;

use yii\base\BaseObject;

class CInterface extends BaseObject
{

	public function __construct($config = []){
		parent::__construct($config);
    }
    
    public function cell($x, $y, $rate){
        $k = $row = $col = 0;
		$rowFlag = $colFlag = false;
		while($k < 8 && !$rowFlag)
		{
		  $row = $k * $rate*(60 + 0);
		  if($y < $row + $rate*60 && $y > $row){
			$rowFlag = true;
			$row = $k;
		  }
		  $k++;
		}
		$k = 0;
		while($k < 8 && !$colFlag)
		{
		  $col = $k * $rate*(60 + 0);
		  if($x < $col + $rate*60 && $x > $col){
			$colFlag = true;
			$col = $k;
		  }
		  $k++;
		}
		$row = 7 - $row;
		return [
            'row'=>$row,
            'column'=>$col,
        ];
	}
	
	public function convert($cell)
	{
		$row = $cell['row'];
		$row = 7 - $row;
		$column = $cell['column'];
		return [
			'x' => $row*60+0,
			'y' => $column*60+0,
		];
	}

	public function determine_class($man, $q)
	{
		$color = $q > 0 ? 'white' : 'black';
		switch($man)
		{
		  case $man == 'p': $name = 'pawn'; break;
		  case $man == 't': $name = 'rook'; break;
		  case $man == 'c': $name = 'knight'; break;
		  case $man == 'd': $name = 'queen'; break;
		  case $man == 'f': $name = 'bishop'; break;
		  case $man == 'r': $name = 'king';
		}
		if(isset($name))
		  return $color . '-' . $name;
		return false;
	}

	public function map_convert($cell, $color)
	{
		return ( $color == -1 ? [
			"row" => 7 - $cell["row"],
			"column" => 7 - $cell["column"]
		] : $cell);
	}

	static function map_str_num($pos)
	{
		$valid_row = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
		if($pos[1] > 8 || $pos[1] < 1 || !in_array($pos[0], $valid_row))
			return false;
		$row = $pos[1] - 1;
		$column = 0;
		switch($pos[0])
		{
			case 'a': $column = 0; break;
			case 'b': $column = 1; break;
			case 'c': $column = 2; break;
			case 'd': $column = 3; break;
			case 'e': $column = 4; break;
			case 'f': $column = 5; break;
			case 'g': $column = 6; break;
			case 'h': $column = 7;
		}
		return [
			'row' => $row,
			'column' => $column
		];
	}

	public function status($board,$status,$q,$man_to,$color)
	{
		$pos = [];
		$i = 1;
		while($i <= 2)
		{
		  if($i == 2 && strcmp($status['man']['pos2'],'T'))
			return $pos;
		  $man = strtolower($status['man']['pos' . $i]);
		  $man_to = strtolower($man_to);
		  $man_id = abs($board[$status['from']['pos' . $i]['row']][$status['from']['pos' . $i]['column']]);
		  $which = ($q==1)?'w':'b';
		  $id_to = abs($board[$status['to']['pos' . $i]['row']][$status['to']['pos' . $i]['column']]);

		  if($id_to == 0 && !strcmp($status['status'],'x'))//e.p.
			$id_to = $board[$status['to']['pos' . $i]['row']-$q][$status['to']['pos' . $i]['column']];

		  $which_opp = ($q==-1)?'w':'b';
		  $to = $this->convert($this->map_convert($status['to']['pos' . $i],$color));
		  $str = "#$which$man-$man_id,$to[x],$to[y],$status[status]";
		  if($id_to != 0)
			  $str .= ",#$which_opp$man_to-$id_to";
		  array_push($pos, $str);
		  $i += 1;
		}
		return $pos;
	}

}