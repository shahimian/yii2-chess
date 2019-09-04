<?php

namespace shahimian\chess\components;

use yii\base\BaseObject;

class Chess extends BaseObject
{

  public function __construct($config = []){
    parent::__construct($config);
  }

  function load($p1, $p2, $play_id = 0)
  {
    $model = Users::model();
    // if players do not connect both would return
    if($model->connect($p1) != 1 && $model->connect($p2) != 1)
      return;


    $users = Users::model()->findAllByPk(array($p1,$p2));
    $users[0]->connect = 2;
    $users[1]->connect = 2;
    $users[0]->save();
    $users[1]->save();
	
	if(!$play_id)
	{
		$play = new ChessStartPlay;
		$play->players = $p1 . '|' . $p2;
		$play->date = date('Y-m-d');
		$play->start = date('H:i:s');
		$play->player_id = $p1;
		$board = new CChessBoard('0:0:25:0:0');
		$play->board = json_encode($board->board);
		if($play->save())
		{
		  ChessUsers::model()->cancel($p2, $p1);
		}
		$play_id = $play->play_id;
	}
	
	ChessUsers::model()->updateAll(array('play_id'=>$play_id),
		'chess_user_id=:p1 OR chess_user_id=:p2',
		array(':p1'=>$p1,':p2'=>$p2)
	);

  }

  function change_man($board,$cm,$q,$cell,$play_id,$color,$game_play = 'real')
  {
    $man_id = abs($board[$cell['row']][$cell['column']]);
    $lcolor = $q > 0 ? 'w' : 'b';

    $valid = new CManValidate($board,array(),$cell,$q);
    $cm_id = $valid->max_man_id($cm, $q) + 1;

    $if = new CInterface;
	$row = $cell['row'];
	$column = $cell['column'];
	$class = $if->determine_class($cm, $q);

    $game = new CGamePlay($board,array(),$cell);
    $board = $game->change_man($cm_id, $q);
	$board['pos'] .= '=' . strtoupper($cm);
	$play = ChessStartPlay::model()->findByPk($play_id);
	$check = new CCheck($board, $cell);
	$this->final_game($q,$cell,$check,$play);
	$board['change'] = '#'.$lcolor.'p-'.$man_id.','.$lcolor.$cm.'-'.$cm_id.",$row,$column,$class";
    $board['players_change'] = $color;
	if($game_play == 'real')
		ChessStartPlay::model()->updateByPk($play_id, array('board'=>json_encode($board)));
	return $board;	
  }

  function decision($data)
  {
    if(isset($data['cell_from']))
    {
      $board = $data['board'];
      $cell1 = $data['cell_from'];
      $cell2 = $data['cell_to'];
      $q = $data['q'];
      $color = $data['color'];
      $play_id = $data['play_id'];
      $rate = $data['rate'];
      $end_game = false;

      if($q != $color) return;

      $play = ChessStartPlay::model()->findByPk($play_id);
	  // check for draw
	  if($board['fifty_moves'] > 50)
	  {
		$play->situation = 'draw';
		$play->save();
		$players = swap_player($play,$q);
		ChessUsers::model()->new_rating(array($players[0], 1), array($players[1], 1));
		echo json_encode(array(
			'situation'=>Yii::t('general','Draw!')
		));
		return;
	  }

      $if = new CInterface;
      $cell1 = $if->map_convert($if->cell($cell1['x'],$cell1['y'],$rate), $q);
      $cell2 = $if->map_convert($if->cell($cell2['x'],$cell2['y'],$rate), $q);

      $valid = new CManValidate($board, $cell1, $cell2, $q);
      $game = new CGamePlay($board, array('pos1'=>$cell1), array('pos1'=>$cell2));
      $_board = $game->change_board();
      $check = new CCheck($_board, $cell2);
	  $where = $check->where_king($q);
      if($check->check($q, $where))
	  {
		$this->final_game(-$q, $cell2, $check, null);
		return;
	  }

      $man = $valid->decision();

      if(strlen($man['man']) == 1)
      {
        $algeb = new CAlgebraicNotation;
        $ins_alg = $algeb->insert($man['man'],$cell1,$cell2,$man['status']);

        list($c, $end_game) = $this->final_game($q,$cell2,$check,$play);
		$ins_alg .= $c;
		
        $pass = $check;
        if(isset($man['special']))
        {
          if(!strcmp($man['special'],'e.p.'))
            $ins_alg .= ' ' . $man['special'];
          elseif(!strcmp($man['special'],'O.O') && $pass->pass('O.O',$q) ||
            !strcmp($man['special'],'O.O.O') && $pass->pass('O.O.O',$q))
            $ins_alg = $man['special'];
          elseif(!strcmp($man['special'],'O.O') || !strcmp($man['special'],'O.O.O'))
          {
            echo 'Route blocked!';
            return;
          }
        }
        if(count($play) == 1)
        {
          if($q > 0)
            $play->position_player1 = $ins_alg;
          else
            $play->position_player2 = $ins_alg;
          if($end_game)
		  {
			$players = $this->swap_player($play,$q);
			ChessUsers::model()->new_rating(array($players[0], 3), array($players[1], -1));
			$play->situation = 'checkmate|' . $players[0];
		  }
          $play->save();
        }
      }

    }
  }
  
  function final_game($q, $cell, $check, $play)
  {
	$end_game = false;
	$c = null;
	$is_check = false;
	$is_checkmate = false;
	if($check->check(-$q, $check->where_king(-$q)))
	{
	  $c = '+';
	  $msg = 'Check';
	  $is_check = true;
	  if($check->check(-$q, $cell))
	  {
		$c = '#';
		$msg .= 'mate';
		$end_game = true;
		if($play)
		{
			$board = json_decode($play->board);
			$board->{'pos'} .= $c;
			$play->board = json_encode($board);
			$play->finish = date('H:i:s');
			$play->save();
		}
		$is_checkmate = true;
	  }
	  $msg .= '!';
	  echo json_encode(array(
		'check'=>$is_check ? Yii::t('general','Check!') : false,
		'situation'=>$is_check,
		'checkmate'=>$is_checkmate ? Yii::t('general','Checkmate!') : false,
		'c2'=>$cell,
		'cell_king'=>$check->where_king(-$q)
	  ));
	}
	return array($c,$end_game);
  }
  
  function swap_player($play,$q)
  {
	$players = explode('|',$play->players);
	if($q < 0)
	{
		$tmp = $players[0];
		$players[0] = $players[1];
		$players[1] = $tmp;
	}
	return array($players[0], $players[1]);
  }

  /*
  request
  1     empty change
  */

  function update($data)
  {
	$play_id = $data['play_id'];
	if(isset($data['timerPlayer']))
	{
		$timer = explode(':', $data['timerPlayer']);
		// check time is zero
		$play = ChessStartPlay::model()->findByPk($play_id);
		$users_id = explode('|', $play->players);
		if(!$timer[2] && !$timer[3] && $timer[4] <= 0)
		{
			$players = $this->swap_player($play);
			ChessUsers::model()->new_rating(array($players[0], 1), array($players[1], 1));
			$play->situation = 'draw';
			echo 'Draw!';
			if($play->save())
				return;
		}
	}
    if(isset($data['request']) && $data['request'] == 1)
    {
      $r = $data['request'];
      $board = json_decode(ChessStartPlay::model()->findByPk($play_id)->board);
      switch($r)
      {
        case 1: $board->{'change'} = ''; break;
      }
      $board = json_encode($board);
      ChessStartPlay::model()->updateByPk($play_id,array('board'=>$board));
      echo $board;
      return;
    }
    $rate = $data['rate'];
    $board = $data['board'];
    $q = $data['q'];
    $color = $data['color'];
	
	$play = ChessStartPlay::model()->findByPk($play_id);
    if(count($play) == 1)
    {
      $_board = json_decode($play->board);
      if(strlen($_board->{'change'}))
      {
        echo json_encode(array('board'=>$_board));
        return;
      }

      $pos = $q > 0 ? $play->position_player1 : $play->position_player2;
	  $timer = "";
	  if(isset($data['timerPlayer']))
		$timer = $data['timerPlayer'];
      $data = $this->player_move($pos,$board,$q,$timer,$color);
	  if($data['stalemate'] || $data['iteration'] || $data['lack'])
	  {
		$players = $this->swap_player($play,$q);
		ChessUsers::model()->new_rating(array($players[0], 1), array($players[1], 1));
	  }
      if(count($data))
      {
        $play->board = json_encode($data['board']);
        if($play->save())
          echo json_encode($data);
      }
    }
  }

  function player_move($pos,$board,$q,$timer,$color){
    if(!strlen($pos))
      return;
    $algeb = new CAlgebraicNotation;
    $status = $algeb->inverse_cell($pos,$q);
    $from = $board[$status['from']['pos1']['row']][$status['from']['pos1']['column']];
    if(!$from)
      return;

    $man_to = 'unknown';
    $to = $board[$status['to']['pos1']['row']][$status['to']['pos1']['column']];
    if(!strcmp($status['status'],'x'))
    {
      $man_to = $this->detectManTo($board,$status,$q);
      $out = $board['out'];
      if(strlen($out))
        $out .= ',';
      $out .= $to;
	  $board['fifty_moves'] = 0;
      $board['out'] = $out;
    } else $board['fifty_moves'] += 1;

    $if = new CInterface;
    $if_status = $if->status($board,$status,$q,$man_to,$color);

    $game = new CGamePlay($board,$status['from'],$status['to']);
    $board = $game->change_board();
    $_pos = $board['pos'];
    if(strlen($_pos)) $_pos .= ',';
    $_pos .= $pos;
    $board['pos'] = $_pos;
	if(strlen($timer))
	{
		if($q == 1)
			$board['timer']['player1'] = $timer;
		else
			$board['timer']['player2'] = $timer;
	}
	$draw = new CDraw($board, -$q);
	$check = new CCheck($board, array());
	$cell2 = array('row'=>$status['to']['pos1']['row'],'column'=>$status['to']['pos1']['column']);
	$king = $check->where_king(-$q);
	$lm = new CLegalMove($board);
	$is_king_move = count($lm->is_legal_move($lm->move('R',$king,-$q),array('pos1'=>$king),-$q)) ? true : false;
	$is_checkmate = $check->check(-$q, $king) && $check->check(-$q, $status['to']['pos1']) ? Yii::t('general','Checkmate!') : false;
	$is_check = $check->check(-$q, $king) && $is_king_move ? Yii::t('general','Check!') : false;
	$is_stalemate = !$check->check(-$q, $king) && $draw->stalemate();
    return array(
      'cur'=>$if_status,
      'board'=>$board,
      'pos'=>$pos,
      'c2'=>$status['to']['pos1'],
	  'cell_king'=>$king,
	  'check'=>$is_check,
	  'checkmate'=>$is_checkmate,
	  'stalemate'=>$is_stalemate,
	  'lack'=>$draw->lack(),
	  'iteration'=>$draw->iteration($_pos)
	);
  }

  function detectManTo($board,$status,$q)
  {
    $valid = new CManValidate($board, $status['from']['pos1'], $status['to']['pos1'], $q);
    $man = $valid->decision();

    if(isset($man['special']) && !strcmp($man['special'],'e.p.'))
      $man = $board[$status['from']['pos1']['row']][$status['to']['pos1']['column']];

    else
    {
      $man = $board[$status['to']['pos1']['row']][$status['to']['pos1']['column']];
      if($man == 0)
        $man = $board[$status['to']['pos1']['row']][$status['to']['pos1']['column']];
    }

    return $valid->man($man);
  }
  
}