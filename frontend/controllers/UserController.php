<?php
namespace frontend\controllers;

use yii\data\ActiveData\ActiveDataProvider;
use Yii;
use yii\filters\VerbFilter;
use common\models\LoginForm;

class UserController extends FrontendController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('user');
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/dashboard']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionIndexx()
    {
        $dataProvider = User::find()->all();
        return $this->render('user', [
                'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    public function actionChoose()
    {
    }
}
