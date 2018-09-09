<?php

  namespace app\models;

  use yii\db\ActiveRecord;

  class Users extends ActiveRecord
  {

      public $second_password;

      public function rules()
      {
          return [

            ['image', 'file', 'extensions' => ['jpg', 'png', 'jpeg']],

            [['login', 'email', 'password'], 'required'],
            ['second_password', 'required', 'message' => 'Необходимо повторить пароль'],
            ['email', 'email'],
          ];

      }

  }


 ?>
