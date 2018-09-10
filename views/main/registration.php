<h1>Registration</h1>

<?php

  use yii\widgets\ActiveForm;
  use yii\helpers\Html;
  $this->title = 'Регистрация';
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $form->field($user, 'login')->label('Login'); ?>
<?= $form->field($user, 'email')->label('E-mail'); ?>
<?= $form->field($user, 'password')->label('Password')->passwordInput(); ?>
<?= $form->field($user, 'second_password')->label('Reply password')->passwordInput(); ?>
<?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end(); ?>
