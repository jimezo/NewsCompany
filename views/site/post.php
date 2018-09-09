<?php

 use yii\helpers\Html;
 use yii\helpers\Url;

 ?>

  <div class="detail-view">

    <img src=" <?= $image_url . $post['image'] ?> " width=600px alt="">
    <h1>Заголовок: <?= $post['title'] ?></h1>
    Автор: <?= Html::a($post->author, Url::to(['/main/personal-area/', 'login' => $post->author]) ) ?>
    <h2>Описание: </h2>
    <p><?= $post['text'] ?> </p>
  </div>
