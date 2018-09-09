<h1>Add post</h1>

<!-- Форма отправки -->
<?php

  use yii\widgets\ActiveForm;
  use yii\helpers\Html;

?>



<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $form->field($model, 'image')->label('Изображение')->fileInput() ?>
<?= $form->field($model, 'title')->label('Заголовок'); ?>
<?= $form->field($model, 'text')->label('Тест')->textarea(); ?>
<?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end(); ?>
