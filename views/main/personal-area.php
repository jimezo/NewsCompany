
<?php
  use yii\widgets\ActiveForm;
  use yii\helpers\Html;
  use yii\helpers\Url;
  if (!$error) {
 ?>



<div class="user-info">
  <?php if (!$user->image) echo 'Изображение отсутвует' ?>
  <img src="<?= $image_url . $user->image ?>" alt="" width='400px'>

  <?php if (Yii::$app->request->cookies->getValue('member_id') == $user->login) { ?>
  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
  <?= $form->field($user, 'image')->label('Изображение')->fileInput() ?>
  <?= Html::submitButton('Изменить', ['class' => 'btn btn-success']) ?>
  <?php ActiveForm::end(); }?>

</div>

<h2 class="user_login">Логин: <?= $user->login ?></h2>
<strong class='user_email'>E-mail: <?= $user->email ?></strong>

  <div class="user_posts">

    <h2>Посты пользователя: </h2>

    <?php
      if ($user_posts)
        foreach ($user_posts as $post) { ?>

          <div class="post">
            <?= Html::a($post->title, Url::to(['/site/post', 'id' => $post->post_id])) ?>
          </div>

    <?php } ?>


  </div>

<?php } else if (!Yii::$app->request->cookies->getValue('member_id')){

    echo '<h1>Вы не авторизованны<h1>';

  } else {
    echo '<h1>' . $error . '<h1>';
  }

?>
