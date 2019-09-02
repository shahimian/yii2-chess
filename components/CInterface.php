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

}