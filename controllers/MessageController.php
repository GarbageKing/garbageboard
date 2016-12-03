<?php

namespace app\controllers;

use Yii;
use app\models\Message;
//use app\models\MessageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\ImageUpload;
use yii\web\UploadedFile;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex()
    {
        
//        $dataProvider = new ActiveDataProvider([
//            'query' => Message::find(),
//        ]);

//        return $this->render('index', [
//            
//            'dataProvider' => $dataProvider,
//        ]);
        return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null)); 
    }

    /**
     * Displays a single Message model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            
        ]);
        
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Message();   
        
        $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        if($model->imageFile != '')        
        {$model->upload();}
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {            
            //return $this->redirect(['view', 'id' => $model->id]);
            Yii::$app->session->setFlash('del_key', $model->del_key);
            return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null)); 
        } else {
            /*return $this->render('create', [
                'model' => $model,
            ]);*/
            return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null)); 
        }
    }

    /**
     * Updates an existing Message model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $param = Yii::$app->getRequest()->getQueryParam('del_key');
        
        if($this->findModel($id)->del_key == $param){
        
        $this->findModel($id)->delete();

        return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null)); }
        else return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null)); 
    }

    /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
