<h1>Login</h1>

<?php

  use yii\widgets\ActiveForm;
  use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $form->field($new_user, 'login')->label('Login'); ?>
<?= $form->field($new_user, 'password')->label('Password')->input('password'); ?>
<?= Html::submitButton('Авторизоваться', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end(); ?>
