<?php
  namespace app\controllers;

  use yii\web\Controller;

  class CommonController extends Controller
  {

    public function strong_print($str)
    {
      return '<strong>' . $str . '</strong>';
    }

  }


 ?>
