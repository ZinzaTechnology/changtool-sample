<?php

namespace frontend\controllers;

use Yii;
use yii\filters\VerbFilter;
use frontend\models\ContactForm;
use frontend\models\User;
use frontend\models\UserTest;
use common\models\TestExam;
use common\models\AnswerClone;
use common\lib\logic\LogicUserTest;
use yii\helpers\Url;

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
   
    public function actionMarkRecord()
    {
        if ($request = Yii::$app->request->post()) {
            UserTest::updateEnd($id, serialize($request));
            return $this->redirect(Url::toRoute(['mark', 'id' => $id]));
        }
            $data = (new UserTest())->getTest($id);
            return $this->render('test/start', [
                        'data' => $data,
                        'time_count' => $time_count,
            ]);
            
    }

   

    public function actionIndex()
    {
        $logicUserTest = new LogicUserTest();
        $userTests = $logicUserTest->findUserTestBySearch(['u_id' => Yii::$app->user->id]);

        return $this->render('index', [
            'user_test_models' => $userTests,
        ]);
    }
    
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
