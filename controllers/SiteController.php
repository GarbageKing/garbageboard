<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Message;
use app\models\Topic;
use yii\data\Pagination;
//use app\models\ImageUpload;
//use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
   /* public function behaviors()
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
     * @inheritdoc
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
        $topic = new Topic();
        $query = Topic::find();
        $count = $query->count();
        $pages = new Pagination(['totalCount' => $count]);        
        
        $topics = $query->orderBy('id')->offset($pages->offset)
        ->limit($pages->limit)->all();
        return $this->render('index', [
            'topics' => $topics, 
            'model' => $topic,
            'pages' => $pages,
        ]);
        
       // return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
   /* public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
   /* public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    /*public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }*/

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionMessagelist()
    {
        $mess = new Message();
        $param = Yii::$app->getRequest()->getQueryParam('topic_id');
        $query = Message::find()->where(['topic_id' => $param]);  
        
        $count = $query->count();
        $pages = new Pagination(['totalCount' => $count]);
        
        $messages = $query->orderBy('id')->offset($pages->offset)
        ->limit($pages->limit)->all();
        
        //$upload = new ImageUpload();
       /* if (Yii::$app->request->isPost) {
            $mess->imageFile = UploadedFile::getInstance($mess, 'imageFile');
            $mess->upload();
        }*/
        
        return $this->render('messagelist', [
            'messages' => $messages, 
            'model' => $mess,
            'pages' => $pages,
            //'upload' => $upload
        ]);
    }
    
}
