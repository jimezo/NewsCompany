<?php

namespace app\controllers;

use app\models\News;
use app\models\Users;
use app\models\PostForm;
use yii\web\UploadedFile;
use yii\web\Cookie;
use Yii;

class MainController extends CommonController
{

  public function actionAddPost()
  {

    $model = new PostForm();

    if ($model->load(Yii::$app->request->post() )) {

      if ($_FILES['PostForm']['name']['image'] ? $model->image = UploadedFile::getInstance($model, 'image') : "");
      $model->author = Yii::$app->request->cookies->getValue('member_id');
      $model->date = date("Y-m-d H-i-s");
      if ($model->save() ) {
        move_uploaded_file($_FILES['PostForm']['name']['image'], '@mediaurl');
        $model->image->saveAs(Yii::getAlias('@mediaurl/' . $model->image->baseName . '.' . $model->image->extension));
        Yii::$app->session->setFlash('success', 'Данные отправленны');
        return $this->refresh();
      }
      else {
        Yii::$app->session->setFlash('error', 'Ошибка');
      }
    }

    return $this->render('add-post', compact('model'));

  }

  public function actionLogin()
  {

      $new_user = new Users;


      if ($new_user->load(Yii::$app->request->post()) ) {

        $all_users = Users::find()
        ->asArray()
        ->all();

        $user_from_db;

        foreach ($all_users as $user) {
            if ($new_user->login == $user['login']) {
                $user_from_db = $user;
                break;
            }
        }


        if ($new_user->login == $user_from_db['login']) {

            if ($new_user->password == $user_from_db['password']) {

              $cookies = Yii::$app->response->cookies;

              // добавление новой куки в HTTP-ответ
              $cookies->add(new \yii\web\Cookie([
                'name' => 'member_id',
                'value' => $new_user->login,
              ]));

                Yii::$app->session->setFlash('success', 'Вы авторизованны');
                return $this->redirect(array('site/index'));
            } else {
              Yii::$app->session->setFlash('error', 'Неверно введен Логин/Пароль');
            }

        } else {
          Yii::$app->session->setFlash('error', 'Пользователя с таким логином не существует');
        }

      }

      return $this->render('login', compact('new_user', 'all_users', 'h'));
  }




  public function actionRegistration()
  {

      $user = new Users();
      $all_users = Users::find()
      ->asArray()
      ->all();

      if ($user->load(Yii::$app->request->post() ))
      {

        foreach ($all_users as $an_user) {
            if ($user->login == $an_user['login']) {
                Yii::$app->session->setFlash('error', 'Пользователь с таким логином уже существует');
                return $this->render('registration', compact('user'));
            }
            if ($user->email == $an_user['email']){
                Yii::$app->session->setFlash('error', 'Пользователь с таким E-mail уже существует');
                return $this->render('registration', compact('user'));
            }
        }

        if ($user->password == $user->second_password) {

          if ($user->save() )
          {
            Yii::$app->session->setFlash('success', 'Данные отправленны <a href="/web/index.php?r=main/login">Авторизоваться</a>');
            return $this->refresh();
          } else {
            Yii::$app->session->setFlash('error', 'Ошибка');
          }

        } else {
          Yii::$app->session->setFlash('error', 'Повторный пароль не совпадает');
        }


      }

      return $this->render('registration', compact('user'));
  }





  public function actionPersonalArea($login = null)
  {

    $error;

    $user = Users::findOne(['login' => $login]);
    $old_img = $user->image;
    $image_url = '../static/images/';

    if (!$user) {
      Yii::$app->session->setFlash('error', 'Такого пользователя не существует');
      return $this->render('personal-area', compact('user', 'error', 'user_posts'));
    }

    $user_posts = PostForm::find()->where(['author' => $login])->all();

    if ($user->load(Yii::$app->request->post() ))
    {
        if ($_FILES['Users']['name']['image'] ? $user->image = UploadedFile::getInstance($user, 'image') : $user->image = $old_img);
        if ($user->save(false) ){

          move_uploaded_file($_FILES['Users']['name']['image'], '@mediaurl');
          $user->image = Yii::getAlias('@mediaurl/' . $user->image->baseName . '.' . $user->image->extension);
          Yii::$app->session->setFlash('success', 'Данные успешно изменены');
          return $this->refresh();
        } else {
          Yii::$app->session->setFlash('error', 'Произошла ошибка');
        }


    }

    return $this->render('personal-area', compact('login', 'user', 'error', 'user_posts', 'image_url'));
  }


  public function actionLogout()
  {
    Yii::$app->response->cookies->remove('member_id');
    return $this->redirect(array('site/index'));
  }


}


 ?>
