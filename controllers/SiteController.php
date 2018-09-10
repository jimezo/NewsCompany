<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\Pagination;

use app\models\News;
use app\models\Users;
use app\models\PostForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */

    public function actionIndex()
    {

        $posts = News::find()
          ->orderBy(['date' => SORT_DESC]);
        $image_url = '../static/images/';

        // get the total number of articles (but do not fetch the article data yet)
        $count = $posts->count();

        // create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 12]);

        // limit the query using the pagination and retrieve the articles
        $articles = $posts->offset($pagination->offset)
                          ->limit($pagination->limit)
                          ->all();


        return $this->render('index', compact('name', 'id', 'posts', 'image_url', 'articles', 'pagination'));
    }

    public function actionPost($id=null)
    {
      $post = News::find()
        ->where(['post_id' => $id])
        ->one();
      $image_url = '../static/images/';
      return $this->render('post', compact('post', 'image_url'));
    }

    public function actionPostChange($id = null)
    {
        $user = Users::findOne(['login' => Yii::$app->request->cookies->getValue('member_id')] );
        $post = PostForm::findOne(['post_id' => $id] );
        $old_img = $post->image;
        $image_url = '../static/images/';

        if ($post->load(Yii::$app->request->post() )) {
            if ($_FILES['PostForm']['name']['image'] == '') {
              $post->image = $old_img;
            } else {
              $post->image = UploadedFile::getInstance($post, 'image');
            }
            $post->date = date("Y-m-d H-i-s");
            if ($post->save() ) {

                move_uploaded_file($_FILES['PostForm']['name']['image'], '@mediaurl');
                $post->image = Yii::getAlias('@mediaurl/' . $post->image->baseName . '.' . $post->image->extension);

                Yii::$app->session->setFlash('success', 'Данные успешно изменены');
                return $this->redirect(['site/index']);
            }


        }

        return $this->render('post-change', compact('user', 'post', 'image_url'));
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionHello()
    {
      return $this->render('hello');
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
