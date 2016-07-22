<?php
namespace frontend\controllers;
use yii\data\ActiveData\ActiveDataProvider;
use Yii;
use yii\filters\VerbFilter;
use common\models\LoginForm;

/**
 * Dashboard controller
 */

class UserController extends FrontendController
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
        ];
    }
    public function actionIndex()
    {
    	return $this->render('user');
    }
    

    /**
     * Login action.
     *
     * @return string
     */
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
    	//$model = new User();
    	//$dataProvider = $model->findAll('u_id');
    	$dataProvider = User::find()->all();
    	 
    	//$dataProvider = Yii::app->findAll()
    	return $this->render('user', [
    			'dataProvider' => $dataProvider,
    	]);
    }
    /**
     * Logout action.
     *
     * @return string
     */
    
    
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    public function actionChoose(){
    	
    }
}
