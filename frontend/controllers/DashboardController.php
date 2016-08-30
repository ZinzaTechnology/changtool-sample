<?php

namespace frontend\controllers;

use Yii;
use common\lib\logic\LogicUserTest;
use common\lib\components\AppConstant;
use common\lib\helpers\AppArrayHelper;
use yii\data\ArrayDataProvider;

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

        $userTestDataProvider = new ArrayDataProvider([
            'allModels' => $userTests,
            'pagination' => [
                'pageSize' => AppConstant::PAGING_INDEX_PAGE_SIZE,
            ],
            'sort' => [
                'attributes' => ['created_at'],
            ],
        ]);
        return $this->render('index', [
            'userTestDataProvider' => $userTestDataProvider,
            'category' => AppConstant::$QUESTION_CATEGORY_NAME,
        ]);
    }
}
