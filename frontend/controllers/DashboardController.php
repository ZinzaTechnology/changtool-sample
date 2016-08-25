<?php

namespace frontend\controllers;

use Yii;
use common\lib\logic\LogicUserTest;
use common\lib\components\AppConstant;
use common\lib\helpers\AppArrayHelper;
use common\models\TestExam;

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
            'category' => AppConstant::$QUESTION_CATEGORY_NAME,
        ]);
    }
}
