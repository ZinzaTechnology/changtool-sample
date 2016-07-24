<?php
namespace frontend\controllers;

use Yii;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use frontend\models\ContactForm;
use yii\data\ActiveDataProvider;
use frontend\models\User;
use yii\widgets\ActiveField;
use backend\models\UserTest;
use backend\models\TestExam;


/**
 * Dashboard controller
 */
class DashboardController extends FrontendController
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

    /**
     * Displays homepage.
     *
     * @return mixed
     */
public function actionIndex()
    {
    	//$model = new User();
    	//$dataProvider = $model->findAll('u_id');
    	$dataProvider = User::find()->all();
    	$user_test_models = UserTest::findAll(['u_id' => 1]);
    	$test_exams = array();
    	foreach($user_test_models as $user_test)
    	{
    		$test_exam = TestExam::findOne($user_test->te_id);
    		array_push($test_exams, $test_exam);
    	}
    	
    	//$dataProvider = Yii::app->findAll()
    	return $this->render('index', [
            'dataProvider' => $dataProvider,
    		'user_test_models' => $user_test_models,
    		'test_exams' => $test_exams,
        ]);
    }
    
    

public function actionTest(){
	$model = new User();
	return $this->render('test',[
			'model'=> $model
	]);
}
    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
    
   
    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

}
