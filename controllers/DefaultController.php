<?php

namespace shahimian\chess\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `chess` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionRequest()
    {
    
        if(!isset($_POST['route']) && !isset($_POST['routeGame']) && !isset($_POST['request']))
        {
            throw new NotFoundHttpException();
        }
      
      
        if(isset($_POST['request']) && is_array($_POST['request']))
        {
            $output = [];
            foreach($_POST['request'] as $request)
            {
                $route = $request['route'];
                $data = isset($request['data']) ? $request['data'] : array();
                $output[$route] = $this->request($route, $data);
            }
            echo json_encode($output);
        }
        else
        {
            $route = isset($_POST['route']) ? $_POST['route'] : $_POST['routeGame'];
            $data = isset($_POST['data']) ? $_POST['data'] : array();
            echo $this->request($route,$data);
        }
    }
  
    private function request($route,$data)
    {
        ob_start();
        $chess = Yii::createObject([
            'class' => Chess::className(),
        ]);
        switch($route)
        {
            case 18:
                $chess->change_man($data['board'],$data['change'],$data['q'],$data['cell'],$data['play_id'],$data['color']);
                $chess->update($data);
            break;
            case 19:
                $chess->decision($data);
                $chess->update($data);
            break;
        }
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
  
}
