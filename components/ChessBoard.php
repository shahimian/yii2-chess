<?php

namespace shahimian\chess\components;

use yii\base\BaseObject;

class ChessBoard extends BaseObject
{
  public $timer;
  public $board;

  public function __construct($config = [])
  {
    parent::__construct($config);
    $this->board = array(
        array_fill(0,8,0),
        array_fill(0,8,0),
        array_fill(0,8,0),
        array_fill(0,8,0),
        array_fill(0,8,0),
        array_fill(0,8,0),
        array_fill(0,8,0),
        array_fill(0,8,0),
        'flag'=>array(
            'start_pawn'=>array(
                'white'=>array_fill(1,8,true),
                'black'=>array_fill(1,8,true),
            ),
            'ep'=>array(
                'white'=>array_fill(1,8,false),
                'black'=>array_fill(1,8,false),
            ),
            'go_rook'=>array(
                'white'=>array(19=>true,9=>true,20=>true),
                'black'=>array(19=>true,9=>true,20=>true),
            ),
        ),
        'pos'=>'',
        'change'=>'',
        'players_change'=>'',
		'fifty_moves'=>0,
        'out'=>'',
		'timer'=>array(
			'player1'=>$this->timer,
			'player2'=>$this->timer,
		),
    );

    for($i=1; $i<=8; $i++)      // pawn
    {
      $this->board[1][$i-1] = $i;
      $this->board[6][$i-1] = -$i;
    }

    // riders

    // white
    // king
    $this->board[0][4] = 9;

    // queen    10..18
    $this->board[0][3] = 10;

    // rook     19..28
    $this->board[0][0] = 19;
    $this->board[0][7] = 20;

    // knight   29..38
    $this->board[0][1] = 29;
    $this->board[0][6] = 30;

    // bishop   39..48
    $this->board[0][2] = 39;
    $this->board[0][5] = 40;

    // black
    // king
    $this->board[7][4] = -9;

    // queen    10..18
    $this->board[7][3] = -10;

    // rook     19..28
    $this->board[7][0] = -19;
    $this->board[7][7] = -20;

    // knight   29..38
    $this->board[7][1] = -29;
    $this->board[7][6] = -30;

    // bishop   39..48
    $this->board[7][2] = -39;
    $this->board[7][5] = -40;

  }

}
