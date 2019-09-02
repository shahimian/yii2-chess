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

}