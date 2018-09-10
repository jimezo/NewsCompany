<?php
  $this->title = 'Изминение поста ' . $post->post_id;
?>

 <h1>Изминение поста <strong><?= $post->title ?></strong></h1>

 <!-- Форма отправки -->
 <?php

   use yii\widgets\ActiveForm;
   use yii\helpers\Html;

 ?>

 <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
 <img src="<?= $image_url . $post->image ?>" alt="" width="400px">
 <?= $form->field($post, 'image')->label('Изображение')->fileInput() ?>
 <?= $form->field($post, 'title')->label('Заголовок'); ?>
 <?= $form->field($post, 'text')->label('Тест')->textarea(); ?>
 <?= Html::submitButton('Изменить', ['class' => 'btn btn-success']) ?>
 <?php ActiveForm::end(); ?>
