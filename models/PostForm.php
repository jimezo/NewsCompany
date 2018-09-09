<?php

  namespace app\models;

  use yii\db\ActiveRecord;

  class PostForm extends ActiveRecord
  {

    public static function tableName()
    {
      return 'posts';
    }

    public function rules() {
      return [

        [['title', 'text', ], 'trim'],

        ['image', 'file', 'skipOnEmpty' => false],
        ['image', 'file', 'extensions' => ['jpg', 'png', 'jpeg']],

        ['title', 'required', 'message' => 'Необходимо заполнить поле «Заголовок»'],
        ['title', 'string', 'min' => 5, 'tooShort' => 'Поле «Заголовок» должен содержать минимум 5 символов.'],
        ['title', 'string', 'max' => 50, 'tooLong' => 'Поле «Заголовок» должен содержать максимум 50 символов.'],

        ['text', 'string', 'max' => 50, 'tooLong' => 'Поле «Текст» должен содержать максимум 50 символов.'],
        ['text', 'string', 'min' => 10, 'tooShort' => 'Поле «Текст» должен содержать минимум 10 символов.'],
        ['text', 'required', 'message' => 'Необходимо заполнить поле Текст'],

      ];
    }

  }



?>
