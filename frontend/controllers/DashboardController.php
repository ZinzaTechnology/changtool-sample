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
        return [];
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
        $logicUserTest = new LogicUserTest();
        $userTests = $logicUserTest->findUserTestBySearch(['u_id' => Yii::$app->user->id]);

        return $this->render('index', [
            'user_test_models' => $userTests,
        ]);
    }

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
}
