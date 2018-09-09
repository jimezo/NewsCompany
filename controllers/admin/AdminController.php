<?php
  namespace app\controllers\admin;

  use yii\web\Controller;

  class AdminController extends Controller
  {

    public function actionAdmin()
    {
      return $this->render('admin');
    }
  }

 ?>
