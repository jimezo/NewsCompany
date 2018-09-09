<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title = 'Main';

if (Yii::$app->request->cookies->getValue('member_id') ) {
  echo Html::a('Add post', 'index.php?r=main/add-post');
}
?>


</br>

<h1>Все посты</h1>

<div class="post">

  <?php

    if ($posts) {
      foreach ($articles as $post) {
        $img = $image_url . $post['image'];

        ?>
        <div class="small-block">
        <?php

        echo '<a href="index.php?r=site/post&id='. $post['post_id'] . '"><img src="' . $img . '"></a>';
        echo '<a href="index.php?r=site/post&id='. $post['post_id'] . '">' . $post['title'] . '</a>';

        ?>
        </div>
        <?php

      }
    } else {
      echo 'Постов нет';
    }


  ?>

</div>

<div class="pagination">
  <?php
    echo LinkPager::widget(['pagination' => $pagination]);
  ?>
</div>
